<nav class="navbar navbar-expand-sm navbar-dark bg-dark py-3">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}"><i class="fas fa-utensils pe-2"></i>Restaurante</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mx-5 mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user pe-2"></i>{{ $user->nome }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('endereco.index') }}">Meus Endereços</a></li>
                        <li><a class="dropdown-item" href="{{ route('reserva.index') }}">Minhas Reservas</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('user.data') }}">Minha Conta</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('auth.logout')}}" class="nav-link">Sair</a>
                </li>
            </ul>
        </div>
    </div>
</nav>