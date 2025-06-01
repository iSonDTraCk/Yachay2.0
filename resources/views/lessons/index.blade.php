@extends('layouts.app')

@section('title')
    {{ session('rol') === 'profesor' ? 'Mis Lecciones' : 'Aprender Lecciones' }}
@endsection

@section('content')
    <h1>
        {{ session('rol') === 'profesor' ? 'Mis Lecciones' : 'Lecciones Disponibles' }}
    </h1>

    @php
        $isProfesor = session('rol') === 'profesor';
    @endphp

    @if($lessons->isEmpty())
        <p>
            {{ $isProfesor ? 'No tienes ninguna lección aún.' : 'No hay lecciones disponibles en este momento.' }}
        </p>
    @else
        @if($isProfesor)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lessons as $lesson)
                        @if(is_object($lesson) && property_exists($lesson, 'title'))
                            <tr>
                                <td>{{ $lesson->title }}</td>
                                <td>
                                    <a href="{{ route('lessons.show', $lesson) }}" class="btn btn-sm btn-primary">Ver</a>
                                    <a href="{{ route('lessons.edit', $lesson) }}" class="btn btn-sm btn-warning">Editar</a>
                                    <form action="{{ route('lessons.destroy', $lesson) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Borrar esta lección?')">
                                            Borrar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @else
            <ul class="list-group">
                @foreach($lessons as $lesson)
                    @if(is_object($lesson) && property_exists($lesson, 'title'))
                        <li class="list-group-item">
                            <a href="{{ route('lessons.show', $lesson) }}">
                                {{ $lesson->title }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        @endif
    @endif
@endsection
