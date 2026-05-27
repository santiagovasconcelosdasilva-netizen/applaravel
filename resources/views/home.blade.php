@extends('layouts.app')

@section('title', 'Loja')

@section('content')
    <section id="produtos" class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="page-title h3 mb-0">Produtos</h1>

        </div>

        @php
            $produtos = [
                ['nome' => 'Portatil', 'preco' => '699,99 $', 'img' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=600&q=80'],
                ['nome' => 'Smartphone', 'preco' => '499,99 $', 'img' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=600&q=80'],
                ['nome' => 'Televisao', 'preco' => '429,99 $', 'img' => 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?auto=format&fit=crop&w=600&q=80'],
                ['nome' => 'Headset Gaming', 'preco' => '59,99 $', 'img' => 'https://images.unsplash.com/photo-1599669454699-248893623440?auto=format&fit=crop&w=600&q=80'],
            ];
        @endphp

        <div class="row g-3">
            @foreach ($produtos as $produto)
                <div class="col-md-6 col-lg-3">
                    <article class="product-card overflow-hidden">
                        <img class="w-100" src="{{ $produto['img'] }}" alt="{{ $produto['nome'] }}">
                        <div class="p-3">
                            <h3 class="h5">{{ $produto['nome'] }}</h3>
                            <div class="price mb-3">{{ $produto['preco'] }}</div>
                            <button class="btn btn-danger w-100" type="button">Comprar</button>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </section>
@endsection
