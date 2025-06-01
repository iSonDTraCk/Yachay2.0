@extends('layouts.app')

@section('title', 'Ñawinchay')

@section('content')
<div>
    <h2 class="mb-4 text-center"><i class="fas fa-book-reader"></i> Ñawinchay (Mi Aprendizaje)</h2>

    {{-- Buscador y Filtros --}}
    <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
        <input type="text" class="form-control flex-grow-1" placeholder="Buscar lección">
        <select class="form-select w-auto">
            <option selected>Universidad: Todas</option>
        </select>
        <select class="form-select w-auto">
            <option selected>Nivel: Todos</option>
        </select>
    </div>

    {{-- Validamos si $lessons existe y no está vacío --}}
    @if (isset($lessons) && $lessons->isNotEmpty())
        {{-- Render dinámico por nivel --}}
        @foreach ($lessons as $level => $group)
            @php
                $colorMap = [
                    'Principiante' => 'success',
                    'Intermedio' => 'warning',
                    'Avanzado' => 'danger',
                    'Superavanzado' => 'dark'
                ];
                $color = $colorMap[$level] ?? 'primary';
            @endphp

            <h4 class="mb-3 text-{{ $color }}">
                <i class="fas fa-layer-group"></i> Nivel: {{ ucfirst($level) }}
            </h4>

            <div class="scroll-wrapper mb-5">
                <div class="scroll-container d-flex flex-nowrap gap-3">
                    @foreach ($group as $lesson)
                        <div class="card shadow-sm flex-shrink-0" style="width: 300px;">
                            <div class="card-body text-center">
                                <div class="fs-1 text-{{ $color }} mb-2"><i class="fas fa-book-open"></i></div>
                                <span class="badge bg-{{ $color }} mb-2 text-uppercase">{{ $lesson->level }}</span>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    <i class="fas fa-school"></i> {{ $lesson->university ?? 'Yachay Wasi' }}
                                </h6>
                                <h5 class="card-title">{{ $lesson->title }}</h5>
                                <p class="card-text">{{ $lesson->description }}</p>
                                <a href="{{ route('lessons.show', $lesson->id) }}" class="btn btn-outline-{{ $color }} btn-sm mt-2">
                                    Ver Detalles
                                </a>
                            </div>
                            <div class="card-footer text-center text-muted">
                                <i class="far fa-calendar-alt"></i> {{ $lesson->start_date }} - {{ $lesson->end_date }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @else
        <p class="text-center text-muted fs-5 mt-5">No hay lecciones disponibles en este momento.</p>
    @endif
</div>

{{-- Estilos personalizados --}}
<style>
    .scroll-wrapper {
        overflow-x: auto;
        overflow-y: hidden;
        padding-bottom: 10px;
        scrollbar-width: thin;
        scrollbar-color: #adb5bd transparent;
        max-width: 100%;
    }

    .scroll-container {
        display: flex;
        flex-wrap: nowrap;
        gap: 1rem;
        overflow: visible;
        padding-top: 20px;
    }

    .scroll-wrapper::-webkit-scrollbar {
        height: 8px;
    }

    .scroll-wrapper::-webkit-scrollbar-thumb {
        background: #adb5bd;
        border-radius: 10px;
    }

    .scroll-wrapper::-webkit-scrollbar-track {
        background: transparent;
    }

    html, body {
        height: 100%;
        overflow-y: auto;
        overflow-x: hidden;
        scroll-behavior: smooth;
    }

    body::-webkit-scrollbar {
        width: 8px;
    }

    body::-webkit-scrollbar-thumb {
        background: #adb5bd;
        border-radius: 10px;
    }

    body::-webkit-scrollbar-track {
        background: transparent;
    }

    .card {
        border-radius: 10px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        z-index: 1;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        z-index: 2;
    }
</style>
@endsection
