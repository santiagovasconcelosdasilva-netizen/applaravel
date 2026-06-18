@extends('layouts.app')

@section('title', 'Detalhes do Contacto - Loja')

@section('content')
    <section class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title mb-0">Detalhes do contacto</h1>
            <a href="{{ route('contactos.index') }}" class="btn btn-secondary">Voltar</a>
        </div>

        <div class="card app-card">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row gap-3 align-items-start mb-4">
                    @if (! empty($contacto->foto_perfil))
                        <img src="{{ asset('storage/' . $contacto->foto_perfil) }}" alt="Foto de perfil" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-secondary text-white" style="width: 150px; height: 150px; font-size: 3rem; font-weight: 700;">
                            {{ strtoupper(mb_substr($contacto->nome, 0, 1)) }}
                        </span>
                    @endif
                    <dl class="row mb-0 flex-fill">
                        <dt class="col-sm-3">Nome</dt>
                        <dd class="col-sm-9">{{ $contacto->nome }}</dd>

                        <dt class="col-sm-3">Alcunha</dt>
                        <dd class="col-sm-9">{{ $contacto->alcunha ?: '-' }}</dd>

                    <dt class="col-sm-3">Telemovel</dt>
                    <dd class="col-sm-9">{{ $contacto->telemovel }}</dd>

                    <dt class="col-sm-3">Email</dt>
                    <dd class="col-sm-9">{{ $contacto->email }}</dd>

                    <dt class="col-sm-3">Localidade</dt>
                    <dd class="col-sm-9">{{ $contacto->localidadeRegisto->localidade ?? $contacto->localidade ?? $contacto->tema ?? '-' }}</dd>

                    <dt class="col-sm-3">Grupo</dt>
                    <dd class="col-sm-9">{{ ucfirst($contacto->grupo ?? '-') }}</dd>

                    <dt class="col-sm-3">Observações</dt>
                    <dd class="col-sm-9">{{ $contacto->observacoes ?? $contacto->mensagem ?? '-' }}</dd>
                </dl>
            </div>
        </div>
    </section>
@endsection