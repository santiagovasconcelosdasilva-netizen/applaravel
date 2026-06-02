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
    @php
        $localidadeAtual = $contacto->localidade ?? $contacto->tema ?? null;
        $localidadeSelecionada = old(
            'localidade_id',
            $contacto->localidade_id ?? ($localidades ?? collect())->firstWhere('localidade', $localidadeAtual)?->id
        );
    @endphp

    <label for="localidade_id" class="form-label">Localidade</label>
    <select name="localidade_id" id="localidade_id" class="form-select @error('localidade_id') is-invalid @enderror">
        <option value="">
            {{ ($localidades ?? collect())->isEmpty() ? 'Sem localidades disponiveis' : 'Seleciona uma localidade' }}
        </option>
        @foreach ($localidades ?? [] as $localidade)
            <option value="{{ $localidade->id }}" @selected((string) $localidadeSelecionada === (string) $localidade->id)>
                {{ $localidade->localidade }}
            </option>
        @endforeach
    </select>
    @error('localidade_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="observacoes" class="form-label">Observações</label>
    <textarea name="observacoes" id="observacoes" rows="5" class="form-control @error('observacoes') is-invalid @enderror">{{ old('observacoes', $contacto->observacoes ?? $contacto->mensagem ?? '') }}</textarea>
    @error('observacoes')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
