@extends('layouts.app')

@section('title', 'Localidades - Loja')

@section('content')

<section class="container mt-4">

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h1 class="page-title mb-1">Localidades</h1>
        <p class="text-muted mb-0">Lista de localidades registadas na loja.</p>
    </div>

    <a href="{{ route('localidades.create') }}" class="btn btn-primary">
       Inserir Localidade
    </a>
</div>

<div class="card app-card">
    <div class="card-body">

        <form action="{{ route('localidades.index') }}" method="GET" class="row g-2 align-items-end mb-4">
            <div class="col-12 col-md">
                <label for="pesquisa" class="form-label">Pesquisar localidade</label>

                <input
                    type="search"
                    name="pesquisa"
                    id="pesquisa"
                    class="form-control"
                    value="{{ $pesquisa ?? '' }}"
                    placeholder="Escreve o nome da localidade">
            </div>

            <div class="col-12 col-md-auto d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    Pesquisar
                </button>

                @if(isset($pesquisa) && $pesquisa !== '')
                    <a href="{{ route('localidades.index') }}" class="btn btn-outline-secondary">
                        Limpar
                    </a>
                @endif
            </div>
        </form>

        @if($localidades->isEmpty())

            <p class="text-muted mb-0">
                Nenhuma localidade encontrada.
            </p>

        @else

            <div class="table-responsive">
               <div class="table-responsive">
                      <table class="table align-middle mb-0">
                         <thead>
                             <tr>
                                 <th>ID</th>
                                 <th>Nome da Localidade</th>
                                 <th>Nº de Contactos</th>
                                 <th>Ações</th>
                             </tr>
                         </thead>


                     <tbody>
                         @foreach($localidades as $localidade)
                             <tr>
                                 <td>{{ $localidade->id }}</td>

                                 <td>{{ $localidade->localidade }}</td>

                                 <td>{{ $localidade->contactos_count }}</td>

                                 <td>
                                     <form method="POST" action="{{ route('localidades.destroy', $localidade->id) }}" style="display:inline;" onsubmit="return confirm('Tem a certeza que quer eliminar esta localidade?');">
                                         @csrf
                                         @method('DELETE')
                                         <button type="submit" class="btn btn-sm btn-outline-danger">
                                             Eliminar
                                         </button>
                                     </form>
                                 </td>
                             </tr>
                         @endforeach
                     </tbody>
                 </table>

                </div>

            </div>

        @endif

    </div>
</div>

</section>
@endsection
