@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 900px;">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-5">
            <div class="d-flex align-items-center mb-3">
                <i class="fas fa-book-open fa-2x text-primary me-3"></i>
                <h2 class="mb-0 fw-bold">{{ $lesson->title }}</h2>
            </div>
            <div class="mb-2">
                <span class="badge bg-secondary me-2"><i class="fas fa-university"></i> {{ $lesson->university }}</span>
                <span class="badge bg-info text-dark">{{ $lesson->level }}</span>
                @if(isset($lesson->status))
                    <span class="badge bg-success ms-2 text-uppercase">{{ $lesson->status }}</span>
                @endif
            </div>
            <p class="mt-3 fs-5">{{ $lesson->description ?? 'Descripción no disponible' }}</p>
            <div class="mb-3 text-muted">
                <i class="far fa-calendar-alt"></i>
                {{ $lesson->start_date ? \Carbon\Carbon::parse($lesson->start_date)->format('d M Y') : 'Fecha de inicio no disponible' }}
                <span class="mx-2">—</span>
                {{ $lesson->end_date ? \Carbon\Carbon::parse($lesson->end_date)->format('d M Y') : 'Fecha de fin no disponible' }}
            </div>

            {{-- Enlaces externos --}}
            @if(!empty($lesson->external_links) && count(array_filter((array)$lesson->external_links)) > 0)
            <div class="mb-4">
                <label class="fw-semibold d-flex align-items-center mb-2 label-title">
                    <span class="icon-circle bg-link-soft me-2"><i class="fas fa-link"></i></span>
                    Enlaces externos:
                </label>
                <div class="scrollable-list-container">
                    <ul class="list-group list-group-flush">
                        @foreach((array) $lesson->external_links as $link)
                            @if($link)
                            <li class="list-group-item ps-0 border-0 bg-transparent">
                                <a href="{{ $link }}" target="_blank" rel="noopener"
                                   class="fw-bold external-link d-flex align-items-center">
                                    <span class="icon-circle bg-link me-2"><i class="fas fa-external-link-alt"></i></span>
                                    <span class="link-text">{{ $link }}</span>
                                </a>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            @else
            <div class="alert alert-warning mt-3">
                <i class="fas fa-exclamation-circle"></i> No hay enlaces externos disponibles.
            </div>
            @endif

            {{-- Recursos adjuntos --}}
            @if(!empty($lesson->resources) && count((array)$lesson->resources) > 0)
            <div class="mb-4">
                <label class="fw-semibold d-flex align-items-center mb-2 label-title">
                    <span class="icon-circle bg-resource-soft me-2"><i class="fas fa-paperclip"></i></span>
                    Recursos adjuntos:
                </label>
                <div class="scrollable-list-container">
                    <ul class="list-group list-group-flush">
                        @foreach((array) $lesson->resources as $resource)
                            <li class="list-group-item ps-0 border-0 bg-transparent">
                                <a href="{{ asset($resource) }}" target="_blank"
                                   class="fw-bold resource-link d-flex align-items-center">
                                    <span class="icon-circle bg-resource me-2"><i class="fas fa-file-alt"></i></span>
                                    <span class="link-text">{{ basename($resource) }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @else
            <div class="alert alert-warning mt-3">
                <i class="fas fa-exclamation-circle"></i> No hay recursos adjuntos disponibles.
            </div>
            @endif

            {{-- Switch para marcar como completado --}}
            <div class="mt-4">
                <form method="POST" action="{{ route('lessons.toggleComplete', $lesson->id) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="completed" value="0">
                    <div class="form-check form-switch d-flex align-items-center gap-3">
                        <input class="form-check-input" type="checkbox" id="completedSwitch" name="completed" value="1" 
                               {{ $lesson->completed ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="form-check-label fw-bold" for="completedSwitch">
                            Marcar como completado
                        </label>
                    </div>
                </form>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('alumno.home') }}" class="btn btn-secondary px-4">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .label-title {
        color: #22223b !important;
        font-weight: 700;
        font-size: 1.18rem;
        letter-spacing: 0.01em;
    }
    .icon-circle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.2rem;
        height: 2.2rem;
        border-radius: 50%;
        font-size: 1.2rem;
        color: #fff;
    }
    .bg-link { background: #2563eb; color: #fff !important; }
    .bg-link-soft { background: #e0e7ff; color: #2563eb !important; }
    .bg-resource { background: #059669; color: #fff !important; }
    .bg-resource-soft { background: #d1fae5; color: #059669 !important; }

    .external-link {
        color: #2563eb !important;
        font-size: 1.08rem;
        border-radius: 0.5rem;
        transition: background 0.2s, color 0.2s;
        padding: 0.25rem 0.5rem;
    }
    .external-link:hover {
        background: #e0e7ff;
        color: #1e40af !important;
        text-decoration: underline;
    }
    .resource-link {
        color: #059669 !important;
        font-size: 1.08rem;
        border-radius: 0.5rem;
        transition: background 0.2s, color 0.2s;
        padding: 0.25rem 0.5rem;
    }
    .resource-link:hover {
        background: #d1fae5;
        color: #065f46 !important;
        text-decoration: underline;
    }
    .link-text {
        word-break: break-all;
    }

    .scrollable-list-container {
        max-height: 240px; /* Altura máxima del contenedor */
        overflow-y: scroll; /* Forzar la visualización del scrollbar vertical */
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 0.75rem;
        padding: 0.75rem;
    }

    .scrollable-list-container::-webkit-scrollbar {
        width: 8px; /* Ancho del scrollbar */
    }
    .scrollable-list-container::-webkit-scrollbar-thumb {
        background: #adb5bd; /* Color del scrollbar */
        border-radius: 10px; /* Bordes redondeados */
    }
    .scrollable-list-container::-webkit-scrollbar-thumb:hover {
        background: #868e96; /* Color al pasar el mouse */
    }

    .form-check-input {
        width: 2rem;
        height: 1rem;
        background-color: #adb5bd;
        border-radius: 1rem;
        transition: background-color 0.2s;
    }
    .form-check-input:checked {
        background-color: #059669;
    }
</style>
@endpush

<script>
    function addLinkInput() {
        const container = document.getElementById('new-links-container');
        const newInput = document.createElement('input');
        newInput.type = 'url';
        newInput.className = 'form-control mb-2';
        newInput.name = 'external_links[]';
        newInput.placeholder = 'https://...';
        container.appendChild(newInput);
    }
</script>
