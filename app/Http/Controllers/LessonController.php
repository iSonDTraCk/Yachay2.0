<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LessonController extends Controller
{
    /**
     * Muestra todas las lecciones agrupadas por nivel.
     * Muestra vistas distintas según el rol: profesor o alumno.
     */
    public function index()
    {
        $lessons = Lesson::all()->groupBy('level');

        $rol = Session::get('rol');

        if ($rol === 'profesor') {
            // Vista para profesor
            return view('lessons.index', compact('lessons'));
        }

        if ($rol === 'alumno') {
            // Vista para alumno (home)
            return view('alumno.home', compact('lessons'));
        }

        abort(403, 'No autorizado');
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

        $request->validate([
            'university'   => 'required|string|max:100',
            'level'        => 'required|in:Principiante,Intermedio,Avanzado,Superavanzado',
            'title'        => 'required|string|max:150',
            'description'  => 'required|string',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
        ]);

        Lesson::create($request->only([
            'university',
            'level',
            'title',
            'description',
            'start_date',
            'end_date'
        ]));

        return redirect()
            ->route('lessons.index')
            ->with('success', 'Lección creada con éxito.');
    }

    /**
     * Muestra una lección individual.
     * Accesible para ambos roles.
     */
    public function show(Lesson $lesson)
    {
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
    
        $validated = $request->validate([
            'university'   => 'required|string|max:100',
            'level'        => 'required|in:Principiante,Intermedio,Avanzado,Superavanzado',
            'title'        => 'required|string|max:150',
            'description'  => 'required|string',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
        ]);
    
        $lesson->update($validated);
    
        // 🔁 Cambia la redirección aquí
        return redirect('/profesor/home')
            ->with('success', 'Lección actualizada con éxito.');
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
            ->route('lessons.index')
            ->with('success', 'Lección eliminada con éxito.');
    }
}
