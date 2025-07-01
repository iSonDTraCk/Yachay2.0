<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage; // Asegúrate de tener esta línea

class LessonController extends Controller
{
    /**
     * Muestra todas las lecciones agrupadas por nivel para el alumno.
     */
    public function alumnoHome()
    {
        // Agrupa las lecciones por nivel
        $courses = Lesson::all()->groupBy('level');

        // Calcular el progreso por nivel
        $progress = [];
        foreach ($courses as $level => $lessons) {
            $totalLessons = count($lessons);
            $completedLessons = $lessons->filter(function ($lesson) {
                return $lesson->completed; // Filtrar las lecciones completadas
            })->count();

            $progress[$level] = [
                'completed' => $completedLessons,
                'total' => $totalLessons,
                'percentage' => $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0,
            ];
        }

        // Retorna la vista con los datos agrupados y el progreso
        return view('alumno.home', compact('courses', 'progress'));
    }

    /**
     * Muestra todas las lecciones para el profesor.
     */
    public function profesorHome()
    {
        $lessons = Lesson::all();
        return view('profesor.home', compact('lessons'));
    }

    /**
     * Muestra el listado de lecciones (para resource).
     * Redirige al home del profesor.
     */
    public function index()
    {
        // Puedes redirigir directamente al home del profesor
        return redirect()->route('profesor.home');
    }

    /**
     * Muestra el formulario de creación.
     * Solo accesible para profesores.
     */
    public function create()
    {
        if (Session::get('rol') !== 'profesor') {
            abort(403, 'No autorizado');
        }

        return view('lessons.create');
    }

    /**
     * Almacena una nueva lección.
     * Solo accesible para profesores.
     */
    public function store(Request $request)
    {
        if (Session::get('rol') !== 'profesor') {
            abort(403, 'No autorizado');
        }

        // Validar los datos
        $validated = $request->validate([
            'university'   => 'required|string|max:100',
            'level'        => 'required|in:Principiante,Intermedio,Avanzado,Superavanzado',
            'title'        => 'required|string|max:150',
            'description'  => 'required|string',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
            'status'       => 'required|string|in:PUBLICADA,BORRADOR', // Validación para el campo status
            'external_links' => 'nullable|array',
            'resources.*'  => 'nullable|file|mimes:pdf,jpg,jpeg,png,mp4|max:20480',
        ]);

        // Crear la lección
        $lesson = new Lesson($validated);

        // Guardar enlaces externos como array/JSON
        $lesson->external_links = array_filter($validated['external_links'] ?? []);

        // Guardar recursos adjuntos (archivos)
        if ($request->hasFile('resources')) {
            $resources = [];
            foreach ($request->file('resources') as $file) {
                $resources[] = $file->store('resources', 'public'); // Guarda en el disco 'public'
            }
            $lesson->resources = $resources;
        }

        $lesson->save();

        return redirect()->route('profesor.home')
            ->with('success', 'Lección creada con éxito.');
    }

    /**
     * Muestra una lección individual.
     * Accesible para ambos roles.
     */
    public function show(Lesson $lesson)
    {
        // Gracias al Route-Model Binding, Laravel ya ha buscado la lección más reciente.
        // Simplemente la pasamos a la vista.
        return view('lessons.show', compact('lesson'));
    }

    /**
     * Muestra el formulario de edición.
     * Solo accesible para profesores.
     */
    public function edit(Lesson $lesson)
    {
        if (Session::get('rol') !== 'profesor') {
            abort(403, 'No autorizado');
        }

        return view('lessons.edit', compact('lesson'));
    }

    /**
     * Actualiza una lección.
     * Solo accesible para profesores.
     */
    public function update(Request $request, Lesson $lesson)
    {
        if (Session::get('rol') !== 'profesor') {
            abort(403, 'No autorizado');
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'resources.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,mp4,mov|max:20480', // max 20MB
            'external_links' => 'nullable|array',
            'external_links.*' => 'nullable|url',
            'task' => 'nullable|string',
            'status' => 'required|string',
        ]);

        // --- Lógica para eliminar recursos existentes ---
        $existingResources = (array) $lesson->resources;
        if ($request->has('resources_to_delete')) {
            $resourcesToDelete = $request->input('resources_to_delete', []);
            foreach ($resourcesToDelete as $resourcePath) {
                // Elimina el archivo físico del storage
                Storage::disk('public')->delete($resourcePath);
            }
            // Filtra el array para quitar los eliminados
            $existingResources = array_diff($existingResources, $resourcesToDelete);
        }

        // --- Lógica para subir nuevos recursos ---
        $newResourcePaths = [];
        if ($request->hasFile('resources')) {
            foreach ($request->file('resources') as $file) {
                $path = $file->store('resources', 'public'); // Guarda en el disco 'public'
                $newResourcePaths[] = $path;
            }
        }
        $finalResources = array_merge($existingResources, $newResourcePaths);


        // --- Lógica para enlaces externos ---
        $existingLinks = (array) $lesson->external_links;
        if ($request->has('links_to_delete')) {
            $linksToDelete = $request->input('links_to_delete', []);
            $existingLinks = array_diff($existingLinks, $linksToDelete);
        }
        $newLinks = array_filter($request->input('external_links', []));
        // Une los enlaces viejos con los nuevos que se hayan añadido
        $finalLinks = array_merge($existingLinks, $newLinks);


        // --- Actualiza la lección en la BD ---
        $lesson->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'level' => $validatedData['level'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'task' => $validatedData['task'],
            'status' => $validatedData['status'],
            'resources' => array_values(array_unique($finalResources)), // Re-indexa y quita duplicados
            'external_links' => array_values(array_unique($finalLinks)),
        ]);

        return redirect()->route('profesor.home')->with('success', 'Lección actualizada correctamente.');
    }

    /**
     * Elimina una lección.
     * Solo accesible para profesores.
     */
    public function destroy(Lesson $lesson)
    {
        if (Session::get('rol') !== 'profesor') {
            abort(403, 'No autorizado');
        }

        $lesson->delete();

        return redirect()
            ->route('profesor.home')
            ->with('success', 'Lección eliminada con éxito.');
    }

    /**
     * Cambia el estado de completado de una lección.
     * Accesible para ambos roles.
     */
    public function toggleComplete(Request $request, Lesson $lesson)
    {
        $lesson->completed = $request->input('completed') == '1';
        $lesson->save();

        return redirect()->route('lessons.show', $lesson->id)->with('success', 'Estado actualizado correctamente.');
    }
}