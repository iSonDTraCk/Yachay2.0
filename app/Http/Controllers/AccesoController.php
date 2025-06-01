<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Alumno;
use App\Models\Profesor;

class AccesoController extends Controller
{
    /**
     * Muestra la página de bienvenida/login
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Procesa el login de alumno o profesor usando DNI y contraseña
     */
    public function login(Request $request)
    {
        $request->validate([
            'dni'      => 'required|digits:8',
            'password' => 'required|string',
            'rol'      => 'required|in:alumno,profesor',
        ]);

        $user = $request->rol === 'alumno'
            ? Alumno::where('dni', $request->dni)->first()
            : Profesor::where('dni', $request->dni)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Guardar el rol en sesión para controlar vistas y permisos
            session(['rol' => $request->rol]);

            return redirect()
                ->route("{$request->rol}.home")
                ->with('success', 'Bienvenido, ' . $user->nombre . '!');
        }

        return back()->with('error', 'Credenciales incorrectas.');
    }

    /**
     * Muestra el formulario de registro según el rol ('alumno' o 'profesor')
     */
    public function registro(string $rol)
    {
        if (! in_array($rol, ['alumno', 'profesor'])) {
            abort(404);
        }

        return view("registro.{$rol}");
    }

    /**
     * Guarda un nuevo alumno (dni, nombre, email y contraseña)
     */
    public function storeAlumno(Request $request)
    {
        $request->validate([
            'dni'                   => 'required|digits:8|unique:alumnos,dni',
            'nombre'                => 'required|string|max:255',
            'email'                 => 'required|email|unique:alumnos,email',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        Alumno::create([
            'dni'      => $request->dni,
            'nombre'   => $request->nombre,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('alumno.home')
                         ->with('success', 'Alumno registrado exitosamente.');
    }

    /**
     * Guarda un nuevo profesor (dni, nombre, email y contraseña)
     */
    public function storeProfesor(Request $request)
    {
        $request->validate([
            'dni'                   => 'required|digits:8|unique:profesors,dni',
            'nombre'                => 'required|string|max:255',
            'email'                 => 'required|email|unique:profesors,email',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        Profesor::create([
            'dni'      => $request->dni,
            'nombre'   => $request->nombre,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profesor.home')
                         ->with('success', 'Profesor registrado correctamente.');
    }

    public function logout(Request $request)
    {
        // Limpia todos los datos de sesión (incluido 'rol')
        $request->session()->flush();

        // Opcional: invalidar la sesión y regenerar el token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('acceso.index');
    }
    
}

