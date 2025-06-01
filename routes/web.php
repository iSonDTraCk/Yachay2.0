<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\AccesoController;

// Página principal con selección de rol/login
Route::get('/', [AccesoController::class, 'index'])->name('acceso.index');
Route::post('/login', [AccesoController::class, 'login'])->name('acceso.login');

// Cerrar sesión
Route::post('/logout', [AccesoController::class, 'logout'])->name('logout');

// Registro de usuarios
Route::get('/registro/{rol}', [AccesoController::class, 'registro'])->name('acceso.registro');
Route::post('/registro/alumno',   [AccesoController::class, 'storeAlumno'])->name('registro.alumno.store');
Route::post('/registro/profesor', [AccesoController::class, 'storeProfesor'])->name('registro.profesor.store');

// Home tras login
Route::get('/alumno/home',   function () { return view('alumno.home');   })->name('alumno.home');
Route::get('/profesor/home', function () { return view('profesor.home'); })->name('profesor.home');

// CRUD de Lecciones (incluye index, create, store, show, edit, update, destroy)
Route::resource('lessons', LessonController::class);
