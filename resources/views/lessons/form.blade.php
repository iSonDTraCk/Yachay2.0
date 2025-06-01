@csrf
<input type="text" name="title" value="{{ old('title', $lesson->title ?? '') }}" placeholder="Título">
<textarea name="content">{{ old('content', $lesson->content ?? '') }}</textarea>
<input type="text" name="level" value="{{ old('level', $lesson->level ?? '') }}" placeholder="Nivel">
<button type="submit">Guardar</button>
