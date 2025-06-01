@extends('layouts.app')

@section('title', 'Registro de Alumno')

@section('content')
<div style="display: flex; justify-content: center; align-items: center; min-height: 100vh; background: #f7f9fc;">
    <div style="width: 100%; max-width: 500px; background: white; padding: 32px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
        <h2 style="margin-bottom: 24px; color: #4f46e5; text-align: center;">Registro de Alumno</h2>

        @if ($errors->any())
            <div style="background: #fee2e2; color: #b91c1c; padding: 12px; border-radius: 6px; margin-bottom: 16px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 16px;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('registro.alumno.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 16px;">
                <label for="dni" style="display: block; font-weight: bold; margin-bottom: 6px;">DNI</label>
                <input type="text" name="dni" id="dni" required maxlength="8" pattern="\d{8}"
                    value="{{ old('dni') }}"
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 16px;">
                <label for="nombre" style="display: block; font-weight: bold; margin-bottom: 6px;">Nombre</label>
                <input type="text" name="nombre" id="nombre" required
                    value="{{ old('nombre') }}"
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 16px;">
                <label for="email" style="display: block; font-weight: bold; margin-bottom: 6px;">Correo electrónico</label>
                <input type="email" name="email" id="email" required
                    value="{{ old('email') }}"
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 16px;">
                <label for="password" style="display: block; font-weight: bold; margin-bottom: 6px;">Contraseña</label>
                <input type="password" name="password" id="password" required minlength="8"
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 24px;">
                <label for="password_confirmation" style="display: block; font-weight: bold; margin-bottom: 6px;">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8"
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;">
            </div>

            <button type="submit"
                style="width: 100%; padding: 12px; background: #4f46e5; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
                Registrar Alumno
            </button>
        </form>

        <div style="margin-top: 16px; text-align: center;">
            <a href="{{ url('/') }}" style="color: #4f46e5; text-decoration: underline;">← Volver al inicio</a>
        </div>
    </div>
</div>
@endsection
