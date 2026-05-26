<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Loja Simples')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f7f7f7;
            color: #222;
        }

        .page-title {
            font-weight: 700;
        }

        .site-header {
            background: #dc3545;
            color: #fff;
        }

        .top-bar {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .site-logo {
            color: #fff;
            font-size: 1.6rem;
            font-weight: 800;
            text-decoration: none;
            white-space: nowrap;
        }

        .top-search {
            flex: 1;
        }

        .top-menu {
            display: flex;
            gap: 0.5rem;
        }

        .top-menu a {
            background: #fff;
            border-radius: 6px;
            color: #dc3545;
            font-weight: 600;
            padding: 0.45rem 0.8rem;
            text-decoration: none;
        }

        .top-menu a:hover {
            background: #f8d7da;
            color: #842029;
        }

        @media (max-width: 768px) {
            .top-bar {
                align-items: stretch;
                flex-direction: column;
            }

            .top-menu a {
                flex: 1;
                text-align: center;
            }
        }

        .hero {
            background: #222;
            color: #fff;
            border-radius: 8px;
            min-height: 260px;
        }

        .app-card,
        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fff;
        }

        .product-card {
            height: 100%;
        }

        .product-card img {
            height: 150px;
            object-fit: contain;
            background: #fafafa;
        }

        .price {
            color: #dc3545;
            font-size: 1.2rem;
            font-weight: 800;
        }
    </style>
</head>
<body>
    <header class="site-header py-3">
        <div class="container">
            <div class="top-bar">
                <a class="site-logo" href="{{ route('contactos.index') }}">Loja Simples</a>

                <div class="top-search">
                    <input class="form-control" type="search" placeholder="Pesquisar produtos...">
                </div>

                <nav class="top-menu">
                    <a href="{{ route('home') }}">Produtos</a>
                    <a href="{{ route('contactos.index') }}">Contactos</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="py-4">
        @if (session('success'))
            <div class="container mb-4">
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
