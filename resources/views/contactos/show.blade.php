@extends('layouts.app')

@section('title', 'Detalhes do Contacto - Loja Simples')

@section('content')
    <section class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title mb-0">Detalhes do contacto</h1>
            <a href="{{ route('contactos.index') }}" class="btn btn-secondary">Voltar</a>
        </div>

        <div class="card app-card">
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">Nome</dt>
                    <dd class="col-sm-9">{{ $contacto->nome }}</dd>

                    <dt class="col-sm-3">Alcunha</dt>
                    <dd class="col-sm-9">{{ $contacto->alcunha ?: '-' }}</dd>

                    <dt class="col-sm-3">Telemovel</dt>
                    <dd class="col-sm-9">{{ $contacto->telemovel }}</dd>

                    <dt class="col-sm-3">Email</dt>
                    <dd class="col-sm-9">{{ $contacto->email }}</dd>

                    <dt class="col-sm-3">Localidade</dt>
                    <dd class="col-sm-9">{{ $contacto->localidade ?? $contacto->tema ?? '-' }}</dd>

                    <dt class="col-sm-3">Observacoes</dt>
                    <dd class="col-sm-9">{{ $contacto->observacoes ?? $contacto->mensagem ?? '-' }}</dd>
                </dl>
            </div>
        </div>
    </section>
@endsection
