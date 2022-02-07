@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <form action="{{ route('endereco.update', $endereco->id) }}" method="POST">
                @csrf
                @method('PUT')
                <fieldset>
                    <legend>Endereço do Usuário: {{ $endereco->user->nome }}</legend>
                    <hr>
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="form-floating col-8 mb-3">
                                <input class="form-control" type="text" name="logradouro" placeholder="" value="{{ $endereco->logradouro }}">
                                <label for="logradouro">Logradouro</label>
                                <span class="text-danger">
                                    @error('logradouro')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-floating col-4 mb-3">
                                <input class="form-control" type="text" name="numero" placeholder="" value="{{ $endereco->numero }}">
                                <label for="numero">Numero</label>
                            </div>

                            <div class="col-4 mb-3 form-floating">
                                <input class="form-control" type="text" name="bairro" placeholder="" value="{{ $endereco->bairro }}">
                                <label for="bairro">Bairro</label>
                                <span class="text-danger">
                                    @error('bairro')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" name="principal" type="checkbox" value="1" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Marcar como principal
                                </label>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Voltar</a>  
                <button type="submit" class="btn btn-success"><i class="fas fa-save me-2"></i>Salvar</button>
            </form>
        </div>
    </div>
@endsection