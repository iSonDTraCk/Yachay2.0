@extends('layouts.app')

@section('title', 'Ñawinchay')

@section('content')
<div class="position-relative">
    <div class="logout-topbar position-absolute end-0 mt-3 me-4" style="z-index:10;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger d-flex align-items-center gap-2 px-4 py-2 rounded-pill shadow-sm fw-bold logout-btn">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
            </button>
        </form>
    </div>

    <h2 class="mb-4 text-center fw-bold" style="font-size:2.5rem;">
        <i class="fas fa-chalkboard-teacher text-success"></i> Ñawinchay <span class="fs-5 text-secondary">(Panel del Profesor)</span>
    </h2>

    {{-- Mensaje de bienvenida --}}
    <div class="alert alert-success text-center fw-bold">
        Bienvenido al Panel del Profesor. Aquí puedes gestionar tus clases.
    </div>

    {{-- Buscador y filtro por nivel en tiempo real --}}
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="input-group shadow rounded-pill">
                <span class="input-group-text bg-white border-0 rounded-start-pill"><i class="fas fa-search text-success"></i></span>
                <input type="text" id="buscador" class="form-control border-0 rounded-0 rounded-end-pill" placeholder="Buscar clase o lección...">
                <select id="nivelFiltro" class="form-select border-0 rounded-pill ms-2" style="max-width:180px;">
                    <option value="Todos">Nivel: Todos</option>
                    <option value="Principiante">Principiante - Ñawpaq</option>
                    <option value="Intermedio">Intermedio - Chawpi</option>
                    <option value="Avanzado">Avanzado - Ñawinchayniyuq</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Validamos si $lessons existe --}}
    @if (isset($lessons) && $lessons->isNotEmpty())
        @php
            $levelColors = [
                'Principiante' => ['#2563eb', '#e0e7ff'],
                'Intermedio'   => ['#198754', '#e9fbe7'],
                'Avanzado'     => ['#fd7e14', '#fff4e6'],
            ];
            $levelTranslations = [
                'Principiante' => 'Ñawpaq',
                'Intermedio' => 'Chawpi',
                'Avanzado' => 'Ñawinchayniyuq',
            ];
            $grouped = $lessons->whereIn('level', ['Principiante','Intermedio','Avanzado'])->groupBy('level');
        @endphp

        @foreach ($grouped as $level => $lessonsByLevel)
            @php
                $color = $levelColors[$level][0] ?? '#6366f1';
                $bgColor = $levelColors[$level][1] ?? '#e0e7ff';
            @endphp
            <h4 class="mb-3 nivel-titulo fw-bold" data-nivel="{{ $level }}" style="color: {{ $color }}">
                <i class="fas fa-layer-group" style="color: {{ $color }}"></i>
                Nivel: <span class="text-capitalize">{{ $level }} <small class="text-muted">({{ $levelTranslations[$level] ?? '' }})</small></span>
            </h4>
            <div class="scroll-wrapper mb-5 nivel-seccion" data-nivel="{{ $level }}">
                <div class="scroll-container d-flex flex-nowrap gap-4">
                    @foreach ($lessonsByLevel as $lesson)
                        @php
                            $cardColor = $levelColors[$lesson->level][0] ?? '#6366f1';
                            $cardBg = $levelColors[$lesson->level][1] ?? '#e0e7ff';
                            $levelQ = $levelTranslations[$lesson->level] ?? '';
                        @endphp
                        <div class="card lesson-card border-0 shadow flex-shrink-0 position-relative"
                             style="width: 340px; background: {{ $cardBg }}; border-top: 6px solid {{ $cardColor }}; margin: 0 16px;"
                             data-nivel="{{ $lesson->level }}">
                            <span class="badge badge-profesor position-absolute top-0 end-0 m-3"
                                  style="background: {{ $cardColor }};">
                                PROFESOR
                            </span>
                            <div class="card-body text-center" style="padding: 2.2rem 1.5rem 1.5rem 1.5rem;">
                                <div class="mb-3">
                                    <i class="fas fa-chalkboard-teacher fa-2x" style="color: {{ $cardColor }}"></i>
                                </div>
                                <span class="badge nivel-badge mb-2 px-3 py-2 fs-6 shadow-sm"
                                      style="background: {{ $cardColor }}; color: #fff; letter-spacing:1px;">
                                    {{ $lesson->level }} <small>({{ $levelQ }})</small>
                                </span>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    <i class="fas fa-school"></i> {{ $lesson->university ?? 'Yachay Wasi' }}
                                </h6>
                                <h5 class="card-title fw-bold text-dark my-3">
                                    {{ $lesson->title }}
                                </h5>
                                <p class="card-text text-secondary" style="min-height:70px;">{{ $lesson->description }}</p>
                                <a href="{{ route('lessons.edit', $lesson->id) }}"
                                   class="btn btn-sm mt-3 rounded-pill px-4 shadow-sm"
                                   style="background: {{ $cardColor }}; color: #fff; font-weight:600;">
                                    Editar
                                </a>
                            </div>
                            <div class="card-footer text-center text-muted bg-white border-0 rounded-bottom py-2">
                                <i class="far fa-calendar-alt"></i>
                                <span class="fw-semibold">{{ $lesson->start_date }} - {{ $lesson->end_date }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @else
        <p class="text-center text-muted fs-5 mt-5">No hay clases registradas aún.</p>
    @endif

    {{-- Botón flotante para crear lección --}}
    <a href="{{ route('lessons.create') }}"
       class="btn btn-success rounded-circle shadow-lg"
       style="position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; z-index: 999;">
        <i class="fas fa-plus"></i>
    </a>
</div>

<div style="height:8px; background:#198754; width:100%;"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buscador = document.getElementById('buscador');
    const nivelFiltro = document.getElementById('nivelFiltro');

    function filtrarTarjetas() {
        const texto = buscador.value.toLowerCase();
        const nivel = nivelFiltro.value;
        const tarjetas = document.querySelectorAll('.lesson-card');
        const secciones = document.querySelectorAll('.nivel-seccion');
        const titulos = document.querySelectorAll('.nivel-titulo');

        tarjetas.forEach(card => {
            const cardNivel = card.getAttribute('data-nivel');
            const cardTexto = card.innerText.toLowerCase();
            const coincideNivel = (nivel === 'Todos' || cardNivel === nivel);
            const coincideTexto = cardTexto.includes(texto);
            card.style.display = (coincideNivel && coincideTexto) ? '' : 'none';
        });

        secciones.forEach((seccion, i) => {
            const visibles = seccion.querySelectorAll('.lesson-card:not([style*="display: none"])').length;
            seccion.style.display = visibles > 0 ? '' : 'none';
            titulos[i].style.display = visibles > 0 ? '' : 'none';
        });
    }

    buscador.addEventListener('input', filtrarTarjetas);
    nivelFiltro.addEventListener('change', filtrarTarjetas);
});
</script>

<style>
html, body {
    height: 100%;
    min-height: 100vh;
    overflow-y: auto;
    overflow-x: hidden;
    scroll-behavior: smooth;
}
body {
    overflow-y: auto !important;
    background: #f4f8fb;
    font-family: 'Segoe UI', 'Arial', sans-serif;
    background-image: url('/images/profesor-watermark.svg');
    background-repeat: no-repeat;
    background-position: right bottom;
    background-size: 300px;
}
.scroll-wrapper {
    overflow-x: auto;
    overflow-y: hidden;
    padding-bottom: 30px;
    scrollbar-width: thin;
    scrollbar-color: #adb5bd transparent;
    max-width: 100%;
}
.scroll-container {
    display: flex;
    flex-wrap: nowrap;
    gap: 3.5rem;
    overflow-x: auto;
    padding-top: 40px;
    padding-bottom: 20px;
}
.scroll-container::-webkit-scrollbar {
    height: 10px;
}
.scroll-container::-webkit-scrollbar-thumb {
    background: #adb5bd;
    border-radius: 10px;
}
.scroll-container::-webkit-scrollbar-track {
    background: transparent;
}
.card {
    border-radius: 22px;
    transition: transform 0.2s, box-shadow 0.2s;
    z-index: 1;
    border: none;
    margin-bottom: 30px;
    margin-top: 20px;
    box-shadow: 0 4px 24px rgba(80, 120, 255, 0.08);
    background: #fff;
    position: relative;
}
.card:hover {
    transform: translateY(-10px) scale(1.04);
    box-shadow: 0 16px 32px rgba(80, 120, 255, 0.16);
    z-index: 2;
}
.nivel-badge {
    font-weight: 600;
    font-size: 1.1rem;
    border-radius: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
}
.badge-profesor {
    background: #198754;
    color: #fff;
    font-size: 0.9rem;
    font-weight: bold;
    border-radius: 12px;
    padding: 0.4em 1em;
    box-shadow: 0 2px 8px rgba(25,135,84,0.15);
}
.btn-success, .btn-outline-success {
    border-radius: 20px;
    font-weight: 500;
    letter-spacing: 0.5px;
    font-size: 1.1rem;
}
.btn-success.rounded-circle:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 16px rgba(25,135,84,0.25);
}
.nivel-titulo {
    font-size: 1.7rem;
    margin-top: 4rem;
    margin-bottom: 2.5rem;
    letter-spacing: 1px;
    text-shadow: 0 2px 8px #e0e7ff;
}
.logout-topbar {
    top: 0;
}
.logout-btn {
    transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
    font-size: 1.1rem;
    letter-spacing: 0.5px;
}
.logout-btn:hover, .logout-btn:focus {
    background: #bb2d3b !important;
    box-shadow: 0 4px 16px rgba(220,53,69,0.15);
    transform: translateY(-2px) scale(1.04);
}
@media (max-width: 900px) {
    .scroll-container {
        gap: 1.5rem;
    }
    .card {
        width: 90vw !important;
        min-width: 250px;
    }
}
.footer-nyw {
    background: #f8fafc;
    border-top: 1px solid #e5e7eb;
    color: #374151;
    font-size: 1rem;
    margin-top: 60px;
}
.footer-nyw img {
    vertical-align: middle;
}
.footer-nyw a {
    color: #2563eb;
    transition: color 0.2s;
}
.footer-nyw a:hover {
    color: #1d4ed8;
}
</style>

<footer class="footer-nyw mt-5 py-4">
    <div class="container text-center">
        <div class="d-flex justify-content-center align-items-center mb-2 gap-3 flex-wrap">
            <img src="{{ asset('images/fondo2.png') }}" alt="Hatun Yachay" style="height:45px;">
            <span class="fw-bold fs-5">Hatun Yachay &copy; {{ date('Y') }}</span>
        </div>
        <div class="mb-2 text-muted fs-6">
            Plataforma educativa para el aprendizaje de lenguas originarias.
        </div>
        <div class="small text-muted">
            Desarrollado por Yachay · Universidad Continental<br>
            <a href="mailto:soporte@hatunyachay.com" class="text-decoration-none text-primary">soporte@hatunyachay.com</a>
        </div>
    </div>
</footer>
@endsection
