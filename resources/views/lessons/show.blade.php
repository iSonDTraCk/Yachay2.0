@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center"><i class="fas fa-book-open"></i> Detalles de la Lección</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">{{ $lesson->title }}</h5>
            <h6 class="card-subtitle mb-2 text-muted"><i class="fas fa-university"></i> {{ $lesson->university }}</h6>
            <span class="badge bg-info">{{ $lesson->level }}</span>

            <p class="mt-3">{{ $lesson->description }}</p>

            <p class="text-muted"><i class="far fa-calendar-alt"></i> 
                {{ \Carbon\Carbon::parse($lesson->start_date)->format('d M Y') }} - 
                {{ \Carbon\Carbon::parse($lesson->end_date)->format('d M Y') }}
            </p>
        </div>

        @if(Session::get('rol') === 'profesor')
        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('lessons.edit', $lesson->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Editar</a>
            <form action="{{ route('lessons.destroy', $lesson->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta lección?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Eliminar</button>
            </form>
        </div>
        @endif
    </div>

    <div class="mt-3 text-center">
        <a href="{{ route('lessons.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
    </div>
</div>
@endsection
