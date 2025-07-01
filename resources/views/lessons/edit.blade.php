@extends('layouts.app')

@section('title', 'Editar Lección')

@section('content')
<div class="container py-5" style="max-height: 90vh; overflow-y: auto;">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4 fw-bold text-primary">
                        <i class="fas fa-chalkboard-teacher"></i> Editar Lección
                    </h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>¡Oops!</strong> Corrige los siguientes errores:<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('lessons.update', $lesson->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Universidad</label>
                                <input type="text" name="university" class="form-control" value="{{ old('university', $lesson->university) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nivel</label>
                                <select name="level" class="form-select" required>
                                    <option value="Principiante" {{ $lesson->level == 'Principiante' ? 'selected' : '' }}>Principiante</option>
                                    <option value="Intermedio" {{ $lesson->level == 'Intermedio' ? 'selected' : '' }}>Intermedio</option>
                                    <option value="Avanzado" {{ $lesson->level == 'Avanzado' ? 'selected' : '' }}>Avanzado</option>
                                    <option value="Superavanzado" {{ $lesson->level == 'Superavanzado' ? 'selected' : '' }}>Superavanzado</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Título</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $lesson->title) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Descripción</label>
                            <textarea name="description" class="form-control" rows="3" required>{{ old('description', $lesson->description) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Fecha de inicio</label>
                                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $lesson->start_date) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Fecha de fin</label>
                                <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $lesson->end_date) }}" required>
                            </div>
                        </div>

                        {{-- RECURSOS ADJUNTOS --}}
                        <div class="mb-3">
                            <label for="resources" class="form-label fw-bold">Recursos adjuntos (PDF, imágenes, videos)</label>
                            
                            {{-- Mostrar recursos existentes con botón de eliminar --}}
                            @if($lesson->resources && count((array)$lesson->resources) > 0)
                                <div class="mb-2">
                                    <p class="mb-1 small text-muted">Recursos actuales:</p>
                                    <ul id="resource-list" class="list-group">
                                        @foreach((array)$lesson->resources as $resource)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span><i class="fas fa-file-alt me-2"></i>{{ basename($resource) }}</span>
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="markForDeletion(this, 'resources_to_delete[]', '{{ $resource }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <input class="form-control" type="file" id="resources" name="resources[]" multiple>
                            <div class="form-text">Puedes adjuntar varios archivos nuevos. Los actuales se mantendrán a menos que los elimines.</div>
                        </div>

                        {{-- ENLACES EXTERNOS --}}
                        <div class="mb-3">
                            <label for="external_links" class="form-label fw-bold">Enlaces externos (YouTube, Google Drive, etc)</label>

                            {{-- Mostrar enlaces existentes con botón de eliminar --}}
                            @if($lesson->external_links && count((array)$lesson->external_links) > 0)
                                <div class="mb-2">
                                    <p class="mb-1 small text-muted">Enlaces actuales:</p>
                                    <ul id="link-list" class="list-group">
                                        @foreach((array)$lesson->external_links as $link)
                                             @if($link)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span class="text-truncate" style="max-width: 80%;"><i class="fas fa-link me-2"></i>{{ $link }}</span>
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="markForDeletion(this, 'links_to_delete[]', '{{ $link }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            <div id="new-links-container">
                                <input type="url" class="form-control mb-2" name="external_links[]" placeholder="https://...">
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addLinkInput()">
                                <i class="fas fa-plus"></i> Añadir otro enlace
                            </button>
                        </div>

                        {{-- Contenedor para los inputs ocultos de elementos a borrar --}}
                        <div id="items-to-delete"></div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tarea / Actividad para el alumno</label>
                            <textarea name="task" class="form-control" rows="2" placeholder="Describe la actividad o tarea asignada">{{ old('task', $lesson->task ?? '') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Estado de la lección</label>
                            <select name="status" class="form-select">
                                <option value="publicada" {{ (old('status', $lesson->status ?? '') == 'publicada') ? 'selected' : '' }}>Publicada</option>
                                <option value="borrador" {{ (old('status', $lesson->status ?? '') == 'borrador') ? 'selected' : '' }}>Borrador</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <button type="button" onclick="history.back()" class="btn btn-secondary px-4">
                                <i class="fas fa-arrow-left"></i> Cancelar
                            </button>

                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-danger px-4" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                                <button type="submit" class="btn btn-primary px-4 fw-bold">
                                    <i class="fas fa-sync-alt"></i> Actualizar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold text-danger" id="confirmDeleteModalLabel">¿Eliminar lección?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        Esta acción eliminará la lección de forma permanente. ¿Estás seguro de que deseas continuar?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <form method="POST" action="{{ route('lessons.destroy', $lesson->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Sí, eliminar</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

<style>
.card {
    border-radius: 2rem;
}
.btn-primary {
    background: #4f46e5;
    border: none;
}
.btn-primary:hover {
    background: #3730a3;
}
.btn-danger {
    background: #dc3545;
    border: none;
}
.btn-danger:hover {
    background: #b91c1c;
}
</style>

@push('scripts')
<script>
function markForDeletion(button, inputName, value) {
    // Eliminar el elemento visualmente
    const listItem = button.closest('li');
    listItem.remove();

    // Crear un input oculto para enviar la info al controlador
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = inputName;
    hiddenInput.value = value;
    
    document.getElementById('items-to-delete').appendChild(hiddenInput);
}

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
@endpush
