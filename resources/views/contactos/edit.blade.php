@extends('layouts.app')

@section('title', 'Editar Contacto - Loja')

@section('content')
    <section class="container">
        <h1 class="page-title mb-4">Editar contacto</h1>

        <div class="card app-card">
            <div class="card-body">
                <form action="{{ route('contactos.update', $contacto) }}" method="POST">
                    @method('PUT')
                    @include('contactos.partials.form')

                    <button type="submit" class="btn btn-primary">Atualizar</button>
                    <a href="{{ route('contactos.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </section>
@endsection
