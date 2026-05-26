@extends('layouts.app')

@section('title', 'Novo Contacto - Loja Simples')

@section('content')
    <section class="container">
        <h1 class="page-title mb-4">Novo contacto</h1>

        <div class="card app-card">
            <div class="card-body">
                <form action="{{ route('contactos.store') }}" method="POST">
                    @include('contactos.partials.form')

                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('contactos.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </section>
@endsection
