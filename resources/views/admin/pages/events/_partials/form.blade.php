<div class="mt-3">
    <x-alert />
</div>

<div class="form-group">
    <label for="name">Nome:</label>
    <input type="text" name="name" id="name" class="form-control" placeholder="Nome:"
        value="{{ $event->name ?? old('name') }}">
</div>

<div class="form-group mt-3 row">
    <div class="col-md-6">
        <label for="location">Localização:</label>
        <input type="text" name="location" id="location" class="form-control" placeholder="Localização:"
            value="{{ $event->location ?? old('location') }}">
    </div>

    <div class="col-md-6">
        <label for="capacity">Capacidade:</label>
        <input type="number" name="capacity" id="capacity" class="form-control" placeholder="Capacidade:"
            value="{{ $event->capacity ?? old('capacity') }}" min="1" step="1">
    </div>
</div>

<div class="form-group mt-3 row">
    <div class="col-md-6">
        <label for="start_date">Data e hora inicio:</label>
        <input type="datetime-local" name="start_date" id="start_date" class="form-control"
            placeholder="Data e hora inicio:" value="{{ $event->start_date ?? old('start_date') }}">
    </div>
    <div class="col-md-6">
        <label for="end_date">Data e hora término:</label>
        <input type="datetime-local" name="end_date" id="end_date" class="form-control"
            placeholder="Data e hora término:" value="{{ $event->end_date ?? old('end_date') }}">
    </div>
</div>

<div class="form-group mt-3">
    <label for="description">Descrição:</label>
    <textarea name="description" id="description" ols="30" rows="5" placeholder="Descrição:"
        class="form-control" style="resize: none">
    {{ $event->description ?? old('description') }}
  </textarea>
</div>

<div class="form-group mt-3">
    <label for="category_id">Categorias:</label>  
    <select name="category_id" id="category_id" class="form-control">
        <option value="">Selecione uma categoria</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}"
                {{ (isset($event) && $event->category_id == $category->id) || old('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>
<div class="form-group mt-4">
    <button type="submit" class="btn btn-dark">Enviar</button>
</div>
