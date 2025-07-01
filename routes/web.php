<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\AccesoController;
use Illuminate\Support\Facades\Auth;


Route::get('/ver-env', function () {
    return response()->json([
        'DB_USERNAME' => env('DB_USERNAME'),
        'DB_PASSWORD' => env('DB_PASSWORD'),
        'DB_DATABASE' => env('DB_DATABASE'),
    ]);
});


// P��gina principal con selección de rol/login
Route::get('/', [AccesoController::class, 'index'])->name('acceso.index');
Route::post('/login', [AccesoController::class, 'login'])->name('acceso.login');

// Cerrar sesi��n
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // Cambia '/login' por '/' si tu login está en la raíz
})->name('logout');

// Registro de usuarios
Route::get('/registro/{rol}', [AccesoController::class, 'registro'])->name('acceso.registro');
Route::post('/registro/alumno',   [AccesoController::class, 'storeAlumno'])->name('registro.alumno.store');
Route::post('/registro/profesor', [AccesoController::class, 'storeProfesor'])->name('registro.profesor.store');

// Home tras login
Route::get('/alumno/home', [LessonController::class, 'alumnoHome'])->name('alumno.home');
Route::get('/profesor/home', [LessonController::class, 'profesorHome'])->name('profesor.home');

// CRUD de Lecciones
Route::resource('lessons', LessonController::class);
Route::get('/lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');
Route::patch('/lessons/{lesson}/toggle-complete', [LessonController::class, 'toggleComplete'])->name('lessons.toggleComplete');

// Para alumnos (opcional, si quieres una vista diferente)
Route::get('/alumno/lessons/{lesson}', [LessonController::class, 'show'])->name('alumno.lessons.show');
