@extends('layouts.app')

@section('title', 'Nova Localidade')

@section('content')
<div class="container mt-4">

    <h1>Nova Localidade</h1>

    <form method="POST" action="#">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nome da Localidade</label>
            <input type="text" name="nome" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">
            Guardar
        </button>

        <a href="{{ route('localidades.index') }}" class="btn btn-secondary">
            Voltar
        </a>
    </form>

</div>
@endsection