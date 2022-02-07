<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Restaurante - Login</title>

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        input{
            border: 0 !important;
            border-radius: 0 !important;
            border-bottom: 1px solid black !important;
        }

        input:focus{
            box-shadow: none !important;
        }
    </style>

</head>
<body>
    <div class="container my-5">
        <div class="row justify-content-around">
            <div class="col-6 align-self-center">
                <img src="{{ url('/img/register-img.jpg')}}" alt="" class="img-fluid w-100 h-100 d-none d-md-block">
            </div>
            <div class="col-12 col-md-6 align-self-center">
                <h2 class="text-center mb-5">Faça seu Cadastro</h2>
                <form action="{{ route('auth.create') }}" method="POST">
                    @csrf

                    <div class="results">
                        @if (Session::get('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        @if (Session::get('fail'))
                        <div class="alert alert-danger">
                            {{ Session::get('fail') }}
                        </div>
                    @endif
                    </div>

                    <fieldset>
                        <div class="form-floating mb-4">
                            <input type="text" name="nome" id="nome" class="form-control" placeholder="Seu nome..." value="{{ old('nome') }}">
                            <label for="nome">Seu nome...</label>
                            <span class="text-danger">
                                @error('nome')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Seu e-mail..." value="{{ old('email') }}">
                            <label for="email">Seu e-mail...</label>
                            <span class="text-danger">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="tel" name="telefone" id="telefone" class="form-control" placeholder="Seu telefone..." value="{{ old('telefone') }}">
                            <label for="telefone">Seu telefone...</label>
                            <span class="text-danger">
                                @error('telefone')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" name="senha" id="senha" class="form-control" placeholder="Sua senha...">
                            <label for="senha">Sua senha...</label>
                            <span class="text-danger">
                                @error('senha')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="text-center mb-5">
                            <button type="submit" class="btn btn-outline-success">Cadastrar</button>
                        </div>
                    </fieldset>
                </form>
                <hr>
            </div>
        </div>
    </div>
</body>
</html>