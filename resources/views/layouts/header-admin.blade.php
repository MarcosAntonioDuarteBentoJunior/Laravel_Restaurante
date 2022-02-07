<nav class="navbar navbar-expand-md navbar-light bg-light py-3">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}"><i class="fas fa-utensils pe-2"></i>Restaurante</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @php
                if(session()->has('LoggedUser')){
                    $user = App\Models\User::find(session('LoggedUser'));
                } else {
                    return redirect()->route('home');
                }
            @endphp
            <ul class="navbar-nav ms-auto mx-5 mb-2 mb-lg-0">
                @if (!strcmp($user->role, 'admin'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Produtos
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Lista de Produtos</a></li>
                            <li><a class="dropdown-item" href="{{ route('item.create') }}">Cadastro</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Clientes
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('user.index') }}">Lista de Clientes</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('agenda.index') }}" class="text-decoration-none nav-link"><i class="fas fa-calendar-alt me-2" title="agenda"></i>Agenda</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link"><i class="fas fa-user me-2"></i>{{ $user->nome }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('auth.logout')}}" class="nav-link">Sair</a>
                </li>
            </ul>
        </div>
    </div>
</nav>