@extends('layouts.app')

@section('title', 'Panel del Profesor')

@section('content')

    <!-- CDN SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif


    <div>
        <h2 class="mb-4 text-center"><i class="fas fa-chalkboard-teacher"></i> Panel del Profesor</h2>

        {{-- Buscador y Filtros --}}
        <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
            <input type="text" class="form-control flex-grow-1" placeholder="Buscar clase o lección">
            <select class="form-select w-auto">
                <option selected>Estado: Todas</option>
                <option>Activas</option>
                <option>Inactivas</option>
            </select>
            <select class="form-select w-auto">
                <option selected>Nivel: Todos</option>
                <option>Principiante</option>
                <option>Intermedio</option>
                <option>Avanzado</option>
            </select>
            <a href="{{ route('lessons.create') }}" class="btn btn-primary">Crear Nueva Clase</a>
        </div>

        {{-- Sección de Clases --}}
        <h4 class="mb-3 text-primary"><i class="fas fa-book"></i> Mis Clases</h4>
        <div class="scroll-wrapper mb-5">
            <div class="scroll-container d-flex flex-nowrap gap-3">
                @for ($i = 1; $i <= 4; $i++)
                <div class="card shadow-sm flex-shrink-0" style="width: 300px;">
                    <div class="card-body text-center">
                        <div class="fs-1 text-primary mb-2"><i class="fas fa-book-open"></i></div>
                        <span class="badge bg-primary mb-2">Clase Activa</span>
                        <h6 class="card-subtitle mb-2 text-muted"><i class="fas fa-school"></i> Yachay Wasi</h6>
                        <h5 class="card-title">Clase de Quechua {{$i}}</h5>
                        <p class="card-text">Descripción breve de la clase. Aquí puedes incluir detalles importantes.</p>
                        <a href="{{ route('lessons.show', $i) }}" class="btn btn-outline-primary btn-sm mt-2">Ver Detalles</a>
                    </div>
                    <div class="card-footer text-center text-muted">
                        <i class="far fa-calendar-alt"></i> 01 Ene - 31 Mar
                    </div>
                </div>
                @endfor
            </div>
        </div>

        {{-- Sección de Lecciones --}}
        <h4 class="mb-3 text-success"><i class="fas fa-graduation-cap"></i> Mis Lecciones</h4>
        <div class="scroll-wrapper mb-5">
            <div class="scroll-container d-flex flex-nowrap gap-3">
                @for ($i = 1; $i <= 4; $i++)
                <div class="card shadow-sm flex-shrink-0" style="width: 300px;">
                    <div class="card-body text-center">
                        <div class="fs-1 text-success mb-2"><i class="fas fa-chalkboard"></i></div>
                        <span class="badge bg-success mb-2">Lección Activa</span>
                        <h6 class="card-subtitle mb-2 text-muted"><i class="fas fa-chalkboard-teacher"></i> Clase {{$i}}</h6>
                        <h5 class="card-title">Lección {{$i}}</h5>
                        <p class="card-text">Contenido breve de la lección. Aquí puedes incluir un resumen.</p>
                        <a href="{{ route('lessons.edit', $i) }}" class="btn btn-outline-success btn-sm mt-2">Editar</a>
                    </div>
                    <div class="card-footer text-center text-muted">
                        <i class="far fa-calendar-alt"></i> 01 Abr - 30 Jun
                    </div>
                </div>
                @endfor
            </div>
        </div>
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
