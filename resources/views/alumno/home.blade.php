@extends('layouts.app')

@section('title', 'Ñawinchay')

@section('content')
<div class="w-100 d-flex justify-content-end align-items-center" style="position: relative; z-index: 20;">
    <form method="POST" action="{{ route('logout') }}" class="mt-4 me-4">
        @csrf
        <button type="submit" class="btn btn-danger d-flex align-items-center gap-2 px-4 py-2 rounded-pill shadow fw-bold logout-btn"
            style="background: #dc3545; border: none; font-size: 1.1rem;">
            <i class="fas fa-sign-out-alt"></i> Cerrar sesión
        </button>
    </form>
</div>

<div>
    <h2 class="mb-4 text-center fw-bold" style="font-size:2.5rem;">
        <i class="fas fa-book-reader text-primary"></i> Ñawinchay <span class="fs-5 text-secondary">(Mi Aprendizaje)</span>
    </h2>

    {{-- Buscador y filtro por nivel en tiempo real --}}
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="input-group shadow rounded-pill">
                <span class="input-group-text bg-white border-0 rounded-start-pill">
                    <i class="fas fa-search text-primary"></i>
                </span>
                <input type="text" id="buscador" class="form-control border-0 rounded-0 rounded-end-pill" placeholder="Buscar clase o lección...">
                <select id="nivelFiltro" class="form-select border-0 rounded-pill ms-2" style="max-width:180px;">
                    <option value="Todos">Nivel: Todos</option>
                    <option value="Principiante">Principiante - Ñawpaq</option>
                    <option value="Intermedio">Intermedio - Chawpi</option>
                    <option value="Avanzado">Avanzado - Ñawinchayniyuq</option>
                    <option value="Superavanzado">Superavanzado - Hatun Yachaq</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Validamos si $courses existe y no está vacío --}}
    @if (isset($courses) && $courses->isNotEmpty())
        @foreach ($courses as $level => $lessons)
            @php
                $progressPercentage = $progress[$level]['percentage'] ?? 0;
                $completedLessons = $progress[$level]['completed'] ?? 0;
                $totalLessons = $progress[$level]['total'] ?? 0;
                $levelColors = [
                    'Principiante' => ['#2563eb', '#dbeafe'], // Azul
                    'Intermedio' => ['#059669', '#d1fae5'],   // Verde
                    'Avanzado' => ['#f59e42', '#fef3c7'],    // Naranja
                    'Superavanzado' => ['#d97706', '#fef9c3'], // Marrón
                ];
                $color = $levelColors[$level][0] ?? '#6366f1';
                $bgColor = $levelColors[$level][1] ?? '#e0e7ff';
            @endphp

            {{-- Título del nivel --}}
            <h4 class="mb-3 nivel-titulo fw-bold" style="color: {{ $color }}">
                <i class="fas fa-layer-group"></i> Nivel: {{ $level }}
            </h4>

            {{-- Barra de progreso --}}
            <div class="progress mb-2" style="height: 25px; background-color: {{ $bgColor }};">
                <div class="progress-bar" role="progressbar" style="width: {{ $progressPercentage }}%; background-color: {{ $color }};" aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100">
                    {{ $progressPercentage }}%
                </div>
            </div>

            {{-- Texto del progreso --}}
            <p class="text-center fw-bold mb-4" style="color: {{ $color }}; font-size: 1.1rem;">
                Completadas: {{ $completedLessons }} / {{ $totalLessons }}
            </p>

            {{-- Contenedor de tarjetas --}}
            <div class="scroll-wrapper mb-5 nivel-seccion" data-nivel="{{ $level }}">
                <div class="scroll-container d-flex flex-nowrap gap-4">
                    @foreach ($lessons as $lesson)
                        <div class="card lesson-card border-0 shadow-lg flex-shrink-0" 
                             style="width: 340px; background: #fff; border-top: 6px solid {{ $color }};" 
                             data-nivel="{{ $level }}">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="fas fa-book-open fa-2x" style="color: {{ $color }}"></i>
                                </div>
                                <span class="badge nivel-badge mb-2 px-3 py-2 fs-6 shadow-sm" style="background: {{ $color }}; color: #fff;">
                                    {{ $lesson->level }}
                                </span>
                                <h5 class="card-title fw-bold">
                                    {{ $lesson->title }}
                                </h5>
                                <p class="card-text">
                                    {{ $lesson->description }}
                                </p>
                                <a href="{{ route('lessons.show', $lesson->id) }}" class="btn btn-outline-primary btn-sm mt-3 rounded-pill px-4 shadow-sm">Ver Detalles</a>
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
    border-radius: 15px;
    transition: transform 0.3s, box-shadow 0.3s;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    background: #fff; /* Fondo blanco para mejor legibilidad */
    margin-bottom: 30px;
    margin-top: 20px;
    overflow: hidden;
}

.card:hover {
    transform: translateY(-10px) scale(1.05);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
}

.card-body {
    padding: 1.5rem;
}

.card-title {
    font-size: 1.4rem;
    font-weight: bold;
    color: #22223b; /* Texto oscuro para contraste */
}

.card-text {
    font-size: 1rem;
    color: #6b7280; /* Texto gris para descripción */
}

.btn-outline-primary {
    border-radius: 20px;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: background-color 0.3s, color 0.3s;
}

.btn-outline-primary:hover {
    background-color: #2563eb;
    color: #fff;
}

.nivel-badge {
    font-weight: 600;
    font-size: 1.1rem;
    border-radius: 14px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
    background-color: #f3f4f6; /* Fondo claro para el badge */
    color: #2563eb; /* Texto azul para el badge */
}

.progress {
    background-color: #f3f4f6; /* Fondo claro para la barra */
    border-radius: 12px;
    overflow: hidden;
    height: 25px;
    box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
}

.progress-bar {
    font-weight: bold;
    text-align: center;
    color: #fff;
    transition: width 0.4s ease;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.text-center {
    font-size: 1.1rem;
    font-weight: 600;
    margin-top: 10px;
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

<style>
.footer-nyw {
    background: #f8fafc;
    border-top: 1px solid #e5e7eb;
    color: #374151;
    font-size: 1rem;
    padding: 20px 0;
}

.footer-nyw img {
    vertical-align: middle;
    height: 50px;
}

.footer-nyw a {
    color: #2563eb;
    transition: color 0.2s;
}

.footer-nyw a:hover {
    color: #1d4ed8;
    text-decoration: underline;
}
</style>
@endsection
