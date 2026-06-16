<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpinMove - @yield('title')</title>

    {{-- AdminLTE --}}
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Seu CSS --}}
    <link rel="stylesheet" href="{{ asset('css/spinmove.css') }}">
</head>

<body class="hold-transition sidebar-mini">

<div class="wrapper">

    {{-- SIDEBAR --}}
    <aside class="main-sidebar elevation-0">
        <a href="#" class="brand-link">
            <span class="brand-text">SpinMove</span>
        </a>

        <div class="sidebar">

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column">

                    <li class="nav-item">
                        <a href="{{ url('/dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('/clientes') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Clientes</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('/bikes') }}" class="nav-link">
                            <i class="nav-icon fas fa-bicycle"></i>
                            <p>Bikes</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('/locacoes') }}" class="nav-link">
                            <i class="nav-icon fas fa-calendar-check"></i>
                            <p>Locações</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('/pagamentos') }}" class="nav-link">
                            <i class="nav-icon fas fa-credit-card"></i>
                            <p>Pagamentos</p>
                        </a>
                    </li>

                </ul>
            </nav>

        </div>
    </aside>

    {{-- CONTENT --}}
    <div class="content-wrapper">

        {{-- TOPBAR --}}
        <nav class="main-header navbar navbar-expand">

            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-bell"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-user-circle"></i>
                    </a>
                </li>

            </ul>

        </nav>

        {{-- CONTEÚDO --}}
        <div class="content">
            <div class="container-fluid py-4">

                @yield('content')

            </div>
        </div>

    </div>

</div>

{{-- JS --}}
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>

</body>
</html>