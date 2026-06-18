@extends('layouts.app')

@section('title', 'Contactos - Loja')

@section('content')
    <section class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h1 class="page-title mb-1">Contactos</h1>
                <p class="text-muted mb-0">Pedidos e contactos de clientes da loja.</p>
            </div>
        </div>

        @if (! $databaseReady)
            <div class="alert alert-warning">
                A tabela dos contactos ainda nao existe. Corre <strong>php artisan migrate</strong> para ativar o CRUD.
            </div>
        @endif

        <div class="card app-card">
            <div class="card-body">
                <form action="{{ route('contactos.index') }}" method="GET" class="row g-2 align-items-end mb-4">
                    @if ($grupo !== '')
                        <input type="hidden" name="grupo" value="{{ $grupo }}">
                    @endif
                    <div class="col-12 col-md">
                        <label for="pesquisa" class="form-label">Pesquisar por nome</label>
                        <input
                            type="search"
                            name="pesquisa"
                            id="pesquisa"
                            class="form-control"
                            value="{{ $pesquisa }}"
                            placeholder="Escreve o nome do contacto"
                        >
                    </div>
                    <div class="col-12 col-md-auto d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Pesquisar</button>
                        @if ($pesquisa !== '')
                            <a href="{{ route('contactos.index') }}" class="btn btn-outline-secondary">Limpar</a>
                        @endif
                    </div>
                </form>

                @if ($grupo !== '')
                    <div class="mb-3">
                        <span class="badge bg-secondary fs-6">Grupo: {{ ucfirst($grupo) }}</span>
                        <a href="{{ route('contactos.index') }}" class="btn btn-sm btn-outline-secondary ms-2">Limpar grupo</a>
                    </div>
                @endif

                @if ($contactos->isEmpty())
                    <p class="text-muted mb-0">
                        @if ($pesquisa !== '' || $grupo !== '')
                            Nao foram encontrados contactos com esses filtros.
                        @else
                            Ainda nao existem contactos registados.
                        @endif
                    </p>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Contacto</th>
                                    <th>Alcunha</th>
                                    <th>Email</th>
                                    <th>Localidade</th>
                                    <th>Grupo</th>
                                    <th class="text-end">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contactos as $contacto)
                                    <tr>
                                        <td class="d-flex align-items-center gap-2">
                                            @if (! empty($contacto->foto_perfil))
                                                <img src="{{ asset('storage/' . $contacto->foto_perfil) }}" alt="Foto de {{ $contacto->nome }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-secondary text-white" style="width: 40px; height: 40px; font-weight: 600;">
                                                    {{ strtoupper(mb_substr($contacto->nome, 0, 1)) }}
                                                </span>
                                            @endif
                                            <span>{{ $contacto->nome }}</span>
                                        </td>
                                        <td>{{ $contacto->alcunha ?: '-' }}</td>
                                        <td>{{ $contacto->email }}</td>
                                        <td>{{ $contacto->localidadeRegisto->localidade ?? $contacto->localidade ?? $contacto->tema ?? '-' }}</td>
                                        <td>{{ ucfirst($contacto->grupo ?? '-') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('contactos.show', $contacto) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                                            <a href="{{ route('contactos.edit', $contacto) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                            <form action="{{ route('contactos.destroy', $contacto) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem a certeza que pretende apagar este contacto?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Apagar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection