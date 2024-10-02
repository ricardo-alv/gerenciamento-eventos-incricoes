@include('admin.includes.alerts')

<div class="form-group">
    <label for="name">Nome:</label>
    <input type="text" name="name" id="name" class="form-control" placeholder="Nome:"
        value="{{ $category->name ?? old('name') }}">
</div>
<div class="form-group mt-2">
    <label for="description">Descrição:</label>
    <textarea name="description" id="description" ols="30" rows="5" placeholder="Descrição:"
        class="form-control" style="resize: none">
    {{ $category->description ?? old('description') }}
  </textarea>
</div>
<div class="form-group mt-4">
    <button type="submit" class="btn btn-dark">Enviar</button>
</div>
