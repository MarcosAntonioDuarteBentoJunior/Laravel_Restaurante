@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="row">
        <h2 class="text-center">Informações da Conta</h2>
        <hr class="mb-4">
        <div class="results">
            @if (Session::get('fail'))
                <div class="alert alert-danger">
                    {{ Session::get('fail') }}
                </div>
            @endif

            @if (Session::get('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif
        </div>
        <div class="px-0">
            <label class="mb-2">Nome:</label>
            <input type="text" class="form-control w-100 mb-3" readonly value="{{ $user->nome }}">
        </div>
        <div class="d-flex justify-content-between mb-3 px-0">
            <div class="col-6">
                <label class="mb-2">Email:</label>
                <input type="email" class="form-control" readonly value="{{ $user->email }}">
            </div>
            <div class="col-4">
                <label class="mb-2">Telefone:</label>
                <input type="tel" class="form-control" readonly value="{{ $user->telefone }}">
            </div>
        </div>
        <div class="mb-4 px-0">
            <label class="mb-2">Senha:</label>
            <div class="d-flex">
                <input type="password" id="password" class="form-control ms-0 w-25 me-3" readonly value="{{ Crypt::decrypt($user->senha) }}">
                <i class="fas fa-eye-slash align-self-center" id="togglePassword"></i>
            </div>
        </div>
        <div>
            <a href="{{ route('user.edit') }}" class="btn btn-outline-primary">Alterar Dados</a>
        </div>

        <h2 class="mt-4 text-center">Endereços Cadastrados</h2>
        <hr class="mb-3">

        @if (!$user->enderecos->isNotEmpty())
            <div class="alert alert-info">Você ainda não cadastrou nenhum endereço !</div>   
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th scope="col">#</th>
                        <th scope="col">Logradouro</th>
                        <th scope="col">Número</th>
                        <th scope="col">Bairro</th>
                        <th scope="col">Principal</th>
                    </thead>
                    <tbody>
                        @foreach ($user->enderecos as $endereco)
                            <tr>
                                <td>{{$endereco->id}}</td>
                                <td>{{ $endereco->logradouro }}</td>
                                <td>{{$endereco->numero ? $endereco->numero : 's/n'}}</td>
                                <td>{{$endereco->bairro}}</td>
                                <td>
                                    @if ($endereco->principal)
                                        <span class="text-success">Sim</span>
                                    @else
                                    <span class="text-danger">Não</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="mt-4 mb-5">
            <a href="{{ route('endereco.index', $user->id) }}" class="btn btn-outline-primary">Gerenciar Meus Endereços</a>
        </div>

    </div>

    <!-- APP JS -->
    <script src="{{ asset('js/app.js') }}"></script>
</div>
@endsection