@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center"><i class="fas fa-edit"></i> Editar Lección</h2>

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

    <form action="{{ route('lessons.update', $lesson->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="university" class="form-label">Universidad</label>
            <input type="text" name="university" class="form-control" id="university" value="{{ old('university', $lesson->university) }}" required>
        </div>

        <div class="mb-3">
            <label for="level" class="form-label">Nivel</label>
            <select name="level" class="form-select" id="level" required>
                @foreach (['Principiante', 'Intermedio', 'Avanzado', 'Superavanzado'] as $lvl)
                    <option value="{{ $lvl }}" {{ $lesson->level === $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $lesson->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" class="form-control" id="description" rows="4" required>{{ old('description', $lesson->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Fecha de inicio</label>
            <input type="date" name="start_date" class="form-control" id="start_date" value="{{ old('start_date', $lesson->start_date) }}" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">Fecha de fin</label>
            <input type="date" name="end_date" class="form-control" id="end_date" value="{{ old('end_date', $lesson->end_date) }}" required>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary"><i class="fas fa-sync-alt"></i> Actualizar</button>
            <a href="{{ route('lessons.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Cancelar</a>
        </div>
    </form>
</div>
@endsection
