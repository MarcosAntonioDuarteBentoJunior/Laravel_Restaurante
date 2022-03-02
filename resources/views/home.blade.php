<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Restaurante</title>

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- CSS PROPRIO -->
    <link rel="stylesheet" href="{{ url('/css/style.css') }}">
    <!-- FAVICON -->
    <link rel="shortcut icon" href="{{url('/img/favicon.png')}}" type="image/x-icon">

</head>
<body>
    <header>
        <nav id="navbar" class="navbar navbar-expand-md navbar-light bg-light py-3">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}"><i class="fas fa-utensils pe-2"></i>Restaurante</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mx-5 mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#scrollspyHeading1">Pratos Populares</a></li>
                                <li><a class="dropdown-item" href="#scrollspyHeading2">Especialidades do Dia</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#scrollspyHeading3">Depoimentos</a>
                        </li>
                    </ul>
                    <div>
                        @if($user)
                            <div class="d-flex">
                                <div class="dropdown me-3">
                                    <a class="dropdown-toggle" href="#" id="Dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-user pe-2"></i>{{ $user->nome }}
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="Dropdown">
                                        <li><a class="dropdown-item" href="{{ route('endereco.index') }}">Meus Endereços</a></li>
                                        <li><a class="dropdown-item" href="{{ route('reserva.index') }}">Minhas Reservas</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="{{ route('user.data') }}">Minha Conta</a></li>
                                    </ul>
                                </div>
    
                                @if ($user->role == 'admin')
                                    <div class="align-self-center">
                                        <a href="{{ route('dashboard') }}" class="text-decoration-none">
                                            <i class="fas fa-user-shield me-3" title="Painel Administrativo"></i>
                                        </a>
                                    </div>
                                @endif
            
                                <a class="text-decoration-none" data-bs-toggle="offcanvas" href="#offcanvasRight" role="button" aria-controls="offcanvasRight">
                                    <i class="fas fa-shopping-cart me-4" title="Meus Pedidos"></i>
                                </a>
            
                                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                                    <div class="offcanvas-header">
                                        <h5 id="offcanvasRightLabel">Meus Pedidos</h5>
                                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body">
                                        <div class="container py-3">
                                            <div class="row">
                                                @if (!is_null($pedidoEmAberto))
                                                    @php
                                                        $items = App\Models\ItemPedido::where('pedido_id', '=', $pedidoEmAberto->id)->count();
                                                    @endphp

                                                    @if ($items)
                                                        @foreach ($pedidoEmAberto->items as $item)
                                                            <div class="justify-content-between d-flex text-center mb-3">
                                                                <div class="me-2 align-self-center">
                                                                    <a href="{{ route('cart.remove', $item->id) }}" class="text-decoration-none">
                                                                        <i class="fa-solid fa-xmark text-danger"></i>
                                                                    </a>
                                                                </div>
                                                                <div class="col-4 align-self-center">
                                                                    <img src="{{ asset('storage/' . $item->image) }}" alt="" class="img-fluid w-50">
                                                                </div>
                                                                <div class="col-4 align-self-center">
                                                                    {{ $item->nome }}
                                                                </div>
                                                                <div class="col-4 align-self-center">
                                                                    R$ {{ number_format($item->preco, 2, ',', '.') }}
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="alert alert-info">
                                                            Seu pedido ainda não possui items!
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="alert alert-info">
                                                        Você não tem nenhum pedido em aberto!
                                                    </div>
                                                @endif
    
                                                @if(!is_null($pedidoEmAberto) && $items)
                                                    <div class="text-center">
                                                        <a href="{{ route('cart.confirm', $pedidoEmAberto->id)}}" class="btn btn-outline-success mt-4">Fechar Pedido</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('auth.logout')}}"><i class="fas fa-sign-out-alt" title="Sair"></i></a>
                                </div>
                            </div>
                        @else
                            <div>
                                <a href="{{ route('login') }}" class="me-4">Login</a>
                                <a href="{{ route('register') }}">Cadastre-se</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <div class="results">
            @if (Session::get('fail'))
                <div class="alert alert-danger w-100 text-center">
                    {{ Session::get('fail') }}
                </div>
            @endif

            @if (Session::get('success'))
                <div class="alert alert-success w-100 text-center">
                    {{ Session::get('success') }}
                </div>
            @endif
        </div>
    </header>

    <main>
        <!-- BOTÃO PARA VOLTAR AO TOPO -->
        <button type="button" class="btn-floating rounded-circle" id="btn-back-to-top">
            <i class="fa-solid fa-angles-up"></i>
        </button>


        <section id="home">
            <div id="carouselExampleIndicators" class="carousel carousel-dark slide mt-5" data-bs-ride="carousel" data-bs-touch="false" data-bs-interval="false">
                <div class="carousel-indicators d-none d-md-flex">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="container">
                            <div class="row">
                                <div class="col-5 align-self-center">
                                    <span class="mb-3 text-uppercase">Nosso Prato Especial</span>
                                    <h3 class="mb-3 fw-bold">Macarrao com Queijo</h3>
                                    <p class="d-none d-md-block">
                                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod qui fuga eos molestias ea quaerat deserunt consequuntur ullam nobis quam in assumenda animi, id maiores eius? Nihil modi eligendi quaerat?
                                    </p>
                                </div>
                                <div class="col-7">
                                    <img src="{{ url('/img/home-img-1.png') }}" class="img-fluid w-100" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="container">
                            <div class="row">
                                <div class="col-5 align-self-center">
                                    <span class="mb-3 text-uppercase">Nosso Prato Especial</span>
                                    <h3 class="mb-3 fw-bold">Frango Assado</h3>
                                    <p class="d-none d-md-block">
                                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod qui fuga eos molestias ea quaerat deserunt consequuntur ullam nobis quam in assumenda animi, id maiores eius? Nihil modi eligendi quaerat?
                                    </p>
                                </div>
                                <div class="col-7">
                                    <img src="{{ url('/img/home-img-2.png') }}" class="img-fluid w-100" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="container">
                            <div class="row">
                                <div class="col-5 align-self-center">
                                    <span class="mb-3 text-uppercase">Nosso Prato Especial</span>
                                    <h3 class="mb-3 fw-bold">Pizza</h3>
                                    <p class="d-none d-md-block">
                                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod qui fuga eos molestias ea quaerat deserunt consequuntur ullam nobis quam in assumenda animi, id maiores eius? Nihil modi eligendi quaerat?
                                    </p>
                                </div>
                                <div class="col-7">
                                    <img src="{{ url('/img/home-img-3.png') }}" class="img-fluid w-100" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev d-none d-md-block" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next d-none d-md-block" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>

        <section id="pratos">
            <div class="container mt-4 py-3" data-bs-spy="scroll" data-bs-target="#navbar">
                <h2 class="text-center" id="scrollspyHeading1">Nossos Pratos</h2>
                <h3 class="text-center text-uppercase">Pratos populares</h3>
                <div class="row py-3 mt-4">
                    @if($pratosPopulares->isNotEmpty())
                        @foreach ($pratosPopulares as $prato)
                            <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-4">
                                <div class="card text-center border-0 h-100">
                                    <img src="{{ asset('storage/' . $prato->image) }}" class="card-img-top" alt="...">
                                    <div class="card-body py-3">
                                        <h5 class="card-title">{{ $prato->nome }}</h5>
                                        <div class="rating mb-3">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="card-text mb-3">
                                            <span>R$ {{ number_format($prato->preco, 2, ',', '.')}}</span>
                                        </div>
                                        <div>
                                            <i class="fas fa-cart-plus pe-2"></i>
                                            <a href="{{ route('cart.show', $prato->id) }}" class="btn btn-outline-primary">Adicionar ao carrinho</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-info">
                            Não há items para mostrar
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <section id="about">
            <div class="container py-4 mt-4">
                <h3 class="text-center">Sobre Nós</h3>
                <h2 class="text-center text-uppercase">Poque nos Escolher ?</h2>
                <div class="row">
                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <img src="{{ url('/img/about-img.png')}}" class="img-fluid w-100 h-100" alt="">
                    </div>
                    <div class="col-12 col-md-6 mb-3 mb-md-0 align-self-center">
                        <h2 class="mb-3">A melhor comida da cidade</h2>
                        <p class="mb-4">
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Amet repellendus officia, doloribus tempora vero maiores hic ullam obcaecati, molestias, eveniet nulla qui saepe. Quaerat recusandae dolores accusantium a tempora doloremque.
                        </p>
                        <p class="mb-4">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis expedita dolores nihil mollitia! Quisquam, eius eaque? Numquam cumque omnis iusto neque illum ducimus officia ullam dicta pariatur reprehenderit, inventore quisquam!
                        </p>
                        <div class="text-center d-flex justify-content-between mb-3">
                            <div>
                                <i class="fas fa-truck"></i> Entrega Grátis
                            </div>
                            <div>
                                <i class="fas fa-file-invoice-dollar"></i> Melhores Preços
                            </div>
                            <div>
                                <i class="fas fa-headset"></i> Atendimento 24h
                            </div>
                        </div>
                        <a href="#!" class="btn">Saiba mais</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="menu">
            <div class="container mt-4 py-3">
                <h3 class="heading mb-3 text-center" id="scrollspyHeading2">Nosso menu</h3>
                <h2 class="sub-heading mb-4 text-center">Especialidades do dia</h2>
                <div class="row py-3 mt-4">
                    @if($especialidades->isNotEmpty())
                        @foreach ($especialidades as $especialidade)
                            <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-4">
                                <div class="card py-2 text-center border-0 h-100">
                                    <img src="{{ asset('storage/' . $especialidade->image) }}" class="card-img-top" alt="...">
                                    <div class="card-body py-3">
                                        <h5 class="card-title">{{ $especialidade->nome }}</h5>
                                        <div class="rating mb-3">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="card-text mb-3">
                                            <span>R$ {{ number_format($especialidade->preco, 2, ',', '.')}}</span>
                                        </div>
                                        <div>
                                            <i class="fas fa-cart-plus pe-2"></i>
                                            <a href="{{ route('cart.show', $especialidade->id) }}" class="btn btn-outline-primary">Adicionar ao carrinho</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-info">
                            Não há items para mostrar
                        </div>
                    @endif
                </div>
        </section>

        <section id="reserva">
            <div class="container d-flex h-100 w-100 py-4">
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-md-6 mb-4 mb-md-0 text-white">
                        <h2 class="fw-bold mb-4">Faça uma reserva agora mesmo !</h2>
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dignissimos neque corporis nostrum reiciendis odio quod voluptatum explicabo officia cupiditate esse eveniet distinctio quaerat, velit dolores ipsam saepe dolorum. Ducimus, optio.</p>
                        <div class="mt-4 d-flex justify-content-between">
                            <div class="phones align-self-center">
                                <i class="fab fa-whatsapp"></i> (19)99965-2948
                            </div>
                            <div class="locale align-self-center">
                                <i class="fas fa-map-marker-alt"></i> Avenida Joao Gerosa, s/n
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-4 mb-md-0">
                        @if($diasHorarios->isNotEmpty())
                            <form action="{{ route('reserva.save') }}" method="POST">
                                @csrf
                                <fieldset>
                                    <div class="form-floating mb-3">
                                        <select name="dataHora" id="dataHora" class="form-select">
                                            <option selected>Data e Horario</option>
                                            @foreach ($diasHorarios as $datas)
                                                <option value="{{ $datas->dataHora }}">{{ date('d/m/Y H:i', strtotime($datas->dataHora)) }}</option>
                                            @endforeach
                                        </select>
                                        <label for="dataHora">Data e Horário</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="number" name="convidados" id="convidados" class="form-control" placeholder="Numero de convidados..." min=0 oninput="validity.valid||(value='');">
                                        <label for="convidados">Número de convidados</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-outline-primary">Fazer um Reserva</button>
                                    </div>
                                </fieldset>
                            </form>
                        @else
                            <div class="text-warning">
                                <h2>
                                    Infelizmente estamos temporariamente sem datas disponíveis para reserva.
                                </h2>
                                <h3 class="mt-3">
                                    Aguarde. Em breve teremos mais datas !
                                </h3>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <section id="reviews" data-bs-spy="scroll" data-bs-target="#navbar">
            <h2 class="text-center mt-4" id="scrollspyHeading3">Depoimentos</h2>
            <hr class="mb-3">
            <div id="carouselExampleFade" class="carousel carousel-dark slide carousel-fade border-bottom border-success" data-bs-ride="carousel">
                <div class="carousel-inner justify-content-between">
                    <div class="carousel-item active">
                        <div class="container py-3">
                            <div class="row mt-3">
                                <div class="col-12 h-25 d-flex mb-4">
                                    <div class="card border-0 col-4 text-center align-self-center">
                                        <img src="{{ url('/img/pic-1.png')}}" class="img-fluid rounded-circle w-50 mx-auto" alt="">
                                        <div class="card-body">
                                            <h5 class="card-title">Fábio</h5>
                                            <div>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8 h-75 align-self-center pe-3 review">
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Corrupti placeat debitis quos assumenda perspiciatis ullam odit earum a incidunt numquam quod provident laboriosam, ipsam eius quas inventore error! Harum, doloribus? Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi culpa recusandae quasi reprehenderit expedita, possimus odio dicta. Iste obcaecati animi eius eos magnam quisquam, minus eligendi laboriosam esse nostrum vitae!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="container py-3">
                            <div class="row mt-3">
                                <div class="col-12 h-25 d-flex mb-4">
                                    <div class="card border-0 col-4 text-center align-self-center">
                                        <img src="{{ url('/img/pic-2.png')}}" class="img-fluid rounded-circle w-50 mx-auto" alt="">
                                        <div class="card-body">
                                            <h5 class="card-title">Ana Cláudia</h5>
                                            <div>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8 h-75 align-self-center pe-3 review">
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Corrupti placeat debitis quos assumenda perspiciatis ullam odit earum a incidunt numquam quod provident laboriosam, ipsam eius quas inventore error! Harum, doloribus? Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi culpa recusandae quasi reprehenderit expedita, possimus odio dicta. Iste obcaecati animi eius eos magnam quisquam, minus eligendi laboriosam esse nostrum vitae!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="container py-3">
                            <div class="row mt-3">
                                <div class="col-12 h-25 d-flex mb-4">
                                    <div class="card border-0 col-4 text-center align-self-center">
                                        <img src="{{ url('/img/pic-3.png')}}" class="img-fluid rounded-circle w-50 mx-auto" alt="">
                                        <div class="card-body">
                                            <h5 class="card-title">Diogo</h5>
                                            <div>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8 h-75 align-self-center pe-3 review">
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Corrupti placeat debitis quos assumenda perspiciatis ullam odit earum a incidunt numquam quod provident laboriosam, ipsam eius quas inventore error! Harum, doloribus? Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi culpa recusandae quasi reprehenderit expedita, possimus odio dicta. Iste obcaecati animi eius eos magnam quisquam, minus eligendi laboriosam esse nostrum vitae!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="container py-3">
                            <div class="row mt-3">
                                <div class="col-12 h-25 d-flex mb-4">
                                    <div class="card border-0 col-4 text-center align-self-center">
                                        <img src="{{ url('/img/pic-4.png')}}" class="img-fluid rounded-circle w-50 mx-auto" alt="">
                                        <div class="card-body">
                                            <h5 class="card-title">Amanda</h5>
                                            <div>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8 h-75 align-self-center pe-3 review">
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Corrupti placeat debitis quos assumenda perspiciatis ullam odit earum a incidunt numquam quod provident laboriosam, ipsam eius quas inventore error! Harum, doloribus? Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi culpa recusandae quasi reprehenderit expedita, possimus odio dicta. Iste obcaecati animi eius eos magnam quisquam, minus eligendi laboriosam esse nostrum vitae!
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>
    </main>

    <footer style="background-color: #deded5;">

        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4">
                    <h5 class="mb-3" style="letter-spacing: 2px; color: #818963;"><i class="fas fa-utensils pe-2"></i>Restaurante</h5>
                    <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iste atque ea quis
                    molestias. Fugiat pariatur maxime quis culpa corporis vitae repudiandae aliquam
                    voluptatem veniam, est atque cumque eum delectus sint!
                    </p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="mb-3" style="letter-spacing: 2px; color: #818963;">Links</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-1">
                            <a href="#!" style="color: #4f4f4f;">Sobre Nós</a>
                        </li>
                        <li class="mb-1">
                            <a href="#!" style="color: #4f4f4f;">Menu</a>
                        </li>
                        <li class="mb-1">
                            <a href="#!" style="color: #4f4f4f;">Depoimentos</a>
                        </li>
                        <li>
                            <a href="#!" style="color: #4f4f4f;">Política de Entregas</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="mb-1" style="letter-spacing: 2px; color: #818963;">Horário de Funcionamento</h5>
                    <table class="table" style="color: #4f4f4f; border-color: #666;">
                        <tbody>
                            <tr>
                                <td>Seg - Sex:</td>
                                <td>9:00 - 15:00</td>
                            </tr>
                            <tr>
                                <td>Sab - Dom:</td>
                                <td>10:00 - 14:00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2021 Copyright: Restaurante - Todos os direitos reservados.
        </div>
        <!-- Copyright -->

        <!-- SCRIPTS -->

        <!-- BOOTSTRAP JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <!-- MAIN JS -->
        <script src="{{ url('/js/app.js')}}"></script>

    </footer>
</body>
</html>