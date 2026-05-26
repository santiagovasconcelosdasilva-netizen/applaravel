@csrf

<div class="mb-3">
    <label for="nome" class="form-label">Nome</label>
    <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome', $contacto->nome ?? '') }}">
    @error('nome')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="alcunha" class="form-label">Alcunha</label>
    <input type="text" name="alcunha" id="alcunha" class="form-control @error('alcunha') is-invalid @enderror" value="{{ old('alcunha', $contacto->alcunha ?? '') }}" placeholder="Opcional">
    @error('alcunha')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="telemovel" class="form-label">Telemovel</label>
    <input type="text" name="telemovel" id="telemovel" class="form-control @error('telemovel') is-invalid @enderror" value="{{ old('telemovel', $contacto->telemovel ?? '') }}">
    @error('telemovel')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $contacto->email ?? '') }}">
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="localidade" class="form-label">Localidade</label>
    <input type="text" name="localidade" id="localidade" class="form-control @error('localidade') is-invalid @enderror" value="{{ old('localidade', $contacto->localidade ?? $contacto->tema ?? '') }}">
    @error('localidade')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="observacoes" class="form-label">Observacoes</label>
    <textarea name="observacoes" id="observacoes" rows="5" class="form-control @error('observacoes') is-invalid @enderror">{{ old('observacoes', $contacto->observacoes ?? $contacto->mensagem ?? '') }}</textarea>
    @error('observacoes')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
