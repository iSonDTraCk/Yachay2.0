@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center"><i class="fas fa-plus-circle"></i> Crear nueva lección</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong> Corrige los siguientes errores:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('lessons.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="university" class="form-label">Universidad</label>
            <input type="text" name="university" class="form-control" id="university" value="{{ old('university') }}" required>
        </div>

        <div class="mb-3">
            <label for="level" class="form-label">Nivel</label>
            <select name="level" class="form-select" id="level" required>
                <option value="">Selecciona un nivel</option>
                <option value="Principiante" {{ old('level') == 'Principiante' ? 'selected' : '' }}>Principiante</option>
                <option value="Intermedio" {{ old('level') == 'Intermedio' ? 'selected' : '' }}>Intermedio</option>
                <option value="Avanzado" {{ old('level') == 'Avanzado' ? 'selected' : '' }}>Avanzado</option>
                <option value="Superavanzado" {{ old('level') == 'Superavanzado' ? 'selected' : '' }}>Superavanzado</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" class="form-control" id="description" rows="4" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Fecha de inicio</label>
            <input type="date" name="start_date" class="form-control" id="start_date" value="{{ old('start_date') }}" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">Fecha de fin</label>
            <input type="date" name="end_date" class="form-control" id="end_date" value="{{ old('end_date') }}" required>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar Lección</button>
            <a href="{{ route('lessons.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Cancelar</a>
        </div>
    </form>
</div>
@endsection
