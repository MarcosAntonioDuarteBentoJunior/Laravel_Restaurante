
@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                <fieldset>
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
                    <div>
                        <label class="mb-2">Nome:</label>
                        <input type="text" name="nome" class="form-control w-100 mb-3" value="{{ $user->nome }}">
                    </div>
                    <span class="text-danger">
                        @error('nome')
                            {{ $message }}
                        @enderror
                    </span>
                    <div class="d-flex justify-content-between mb-3 px-0">
                        <div class="col-6">
                            <label class="mb-2">Email:</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                            <span class="text-danger">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-4">
                            <label class="mb-2">Telefone:</label>
                            <input type="tel" name="telefone" class="form-control" value="{{ $user->telefone }}">
                            <span class="text-danger">
                                @error('telefone')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="mb-4 px-0">
                        <label class="mb-2">Nova Senha:</label>
                        <input type="password" name="novaSenha" id="password" class="form-control ms-0 w-50 me-3" placeholder="Nova senha (deixe em branco para manter a senha atual)">
                        <span class="text-danger">
                            @error('novaSenha')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="mb-4 px-0">
                        <label class="mb-2">Senha Atual:</label>
                        <input type="password" name="senhaAtual" class="form-control ms-0 w-25 me-3" placeholder="Senha atual" required>
                        <span class="text-danger">
                            @error('senhaAtual')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-outline-success">Confirmar Alterações</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
@endsection