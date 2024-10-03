<div class="mt-3">
    <x-alert />
</div>

<div class="form-group">
    <label for="name">Nome:</label>
    <input type="text" name="name" id="name" class="form-control" placeholder="Nome:"
        value="{{ $user->name ?? old('name') }}">
</div>

<div class="mb-3">
    <label for="cpf" class="form-label">CPF</label>
    <input id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf"
        value="{{ $user->cpf ?? old('cpf') }}" required autocomplete="cpf" autofocus
        {{ isset($user) ? 'disabled' : '' }}>

</div>

<div class="mb-3">
    <label for="data_birth" class="form-label">Data Nascimento</label>
    <input id="data_birth" type="date" class="form-control @error('data_birth') is-invalid @enderror"
        name="data_birth" value="{{ $user->data_birth ?? old('data_birth') }}" required autocomplete="data_birth"
        autofocus>
</div>


<div class="mb-3">
    <label for="address" class="form-label">Endereço</label>
    <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address"
        value="{{ $user->address ?? old('address') }}" required autocomplete="email" autofocus>

</div>

<hr class="mt-4">
<h6>Login e senha</h6>

<!-- Email Address -->
<div class="mb-3 mt-3">
    <label for="email" class="form-label">E-mail</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
        value="{{ $user->email ?? old('email') }}" required autocomplete="email" {{ isset($user) ? 'disabled' : '' }}>
</div>

@if (!isset($user))
    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
            name="password" required autocomplete="new-password">
    </div>

    <!-- Confirm Password -->
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmar Senha</label>
        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
            id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
    </div>
@endif

<div class="form-group mt-4">
    <button type="submit" class="btn btn-dark">Enviar</button>
</div>
