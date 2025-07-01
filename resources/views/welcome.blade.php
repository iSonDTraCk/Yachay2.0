@extends('layouts.app')

@section('title', 'Bienvenido')

@section('content')
<style>
    html, body {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        font-family: Arial, sans-serif;
    }

    .welcome-container {
        position: relative;
        width: 100%;
        min-height: 100vh;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 1rem;
        box-sizing: border-box;
    }

    .welcome-background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-image: url('/images/fondo1.jpeg');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        z-index: 1;
    }

    .welcome-content {
        position: relative;
        z-index: 2;
        background-color: #ffffff;
        padding: 2.5rem;
        border-radius: 12px;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 400px;
        text-align: center;
        box-sizing: border-box;
    }

    .welcome-logo {
        width: 90px;
        margin-bottom: 1rem;
    }

    .welcome-title {
        font-size: 2rem;
        font-weight: bold;
        color: #B03060; /* Magenta brillante */
        margin-bottom: 0.5rem;
    }

    .welcome-subtitle {
        font-size: 1.25rem;
        margin-bottom: 1.5rem;
        color: #000000; /* Magenta oscuro SELCT ROL*/
    }

    .form-group {
        margin-bottom: 1rem;
        text-align: left;
    }

    .form-input {
        width: 100%;
        padding: 0.5rem;
        border-radius: 6px;
        border: 1px solid #E89AC8; /* Rosa claro */
        box-sizing: border-box;
    }

    .btn-primary {
        width: 100%;
        padding: 0.6rem;
        background-color: #B03060; /* Magenta oscuro */
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #FF00CC; /* Magenta brillante */
    }

    .register-links {
        margin-top: 1rem;
        font-size: 0.9rem;
        text-align: center;
    }

    .register-links a {
        margin: 0 0.5rem;
        color: #B03060;
        text-decoration: none;
    }

    .register-links a:hover {
        text-decoration: underline;
    }

    .form-error {
        color: red;
        font-size: 0.8rem;
    }

    .alert-error {
        color: white;
        background-color: red;
        padding: 0.5rem;
        margin-bottom: 1rem;
        border-radius: 6px;
    }

    @media screen and (max-width: 768px) {
        .welcome-content {
            padding: 1.5rem;
        }

        .welcome-title {
            font-size: 1.5rem;
        }

        .welcome-subtitle {
            font-size: 1rem;
        }
    }

    @media screen and (max-width: 480px) {
        .welcome-content {
            padding: 1rem;
        }

        .welcome-title {
            font-size: 1.2rem;
        }

        .welcome-subtitle {
            font-size: 0.95rem;
        }

        .register-links {
            font-size: 0.8rem;
        }
    }
</style>

<div class="welcome-container">
    <div class="welcome-background"></div>

    <div class="welcome-content">
        <!-- Logo HY -->
        <img src="{{ asset('images/fondo2.png') }}" alt="Logo Yachay" class="welcome-logo">
        <h1 class="welcome-title">Hatun Yachay</h1>
        <h2 class="welcome-subtitle">Selecciona tu rol  </h2>

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('acceso.login') }}">
            @csrf

            <div class="form-group">
                <label for="dni">DNI:</label>
                <input type="text" name="dni" maxlength="8" required pattern="\d{8}" placeholder="Ingresa tu DNI" class="form-input">
                @error('dni')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" required placeholder="Ingresa tu contraseña" class="form-input">
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="rol">Rol:</label><br>
                <label><input type="radio" name="rol" value="alumno" required> Alumno</label>
                <label><input type="radio" name="rol" value="profesor"> Profesor</label>
                @error('rol')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Ingresar</button>
        </form>

        <div class="register-links">
            <p>¿Aún no tienes cuenta?</p>
            <a href="{{ route('acceso.registro', ['rol' => 'alumno']) }}">Crear como Alumno</a>
            <a href="{{ route('acceso.registro', ['rol' => 'profesor']) }}">Crear como Profesor</a>
        </div>
    </div>
</div>
@endsection
