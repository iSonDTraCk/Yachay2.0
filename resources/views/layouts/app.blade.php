<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Yachay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    
    <style>
        .navbar-brand.fucsia {
            color: #FF00FF !important;
            font-weight: bold;
            font-size: 1.8rem;
        }
        .search-bar {
            position: relative;
            max-width: 300px;
        }
        .search-bar i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        .search-bar input {
            padding-left: 35px;
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }
        .course-card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .course-card:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .course-thumbnail {
            position: relative;
            padding-top: 56.25%;
            background: #f8f9fa;
        }
        .course-level {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #4CAF50;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
        .course-play-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 48px;
            opacity: 0.8;
            transition: all 0.3s ease;
        }
        .course-play-button:hover {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1.1);
        }
        .filter-section {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        .view-toggle button {
            padding: 8px;
            border: 1px solid #dee2e6;
            background: none;
            border-radius: 4px;
        }
        .view-toggle button.active {
            background: #4CAF50;
            color: white;
            border-color: #4CAF50;
        }
    </style>
</head>
<body class="scroll-container">
    {{-- Navbar --}}
    {{-- Navbar (oculta en la página de login) --}}
    @if (!request()->routeIs('acceso.index'))
    @endif

    {{-- Contenido principal --}}
    <div class="container">
        @yield('content')
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
