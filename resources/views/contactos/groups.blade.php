@extends('layouts.app')

@section('title', 'Grupos - Loja')

@section('content')
    <section class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h1 class="page-title mb-1">Grupos</h1>
                <p class="text-muted mb-0">Veja quantos contactos existem em cada grupo.</p>
            </div>
            <a href="{{ route('contactos.index') }}" class="btn btn-secondary">Voltar para Contactos</a>
        </div>

        <div class="row g-3">
            @foreach ($grupos as $key => $label)
                <div class="col-12 col-md-4">
                    <div class="card app-card p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="h5 mb-1">{{ $label }}</h2>
                                <p class="mb-0 text-muted">{{ $counts[$key] ?? 0 }} contactos</p>
                            </div>
                            <a href="{{ route('contactos.index', ['grupo' => $key]) }}" class="btn btn-outline-primary btn-sm">Ver</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
