@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Cadastro de produto</h2>
        <form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <fieldset>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome do Produto">
                    <label for="nome">Nome do Produto</label>
                    <span class="text-danger">
                        @error('nome')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="preco" id="preco" placeholder="Preço do Produto">
                    <label for="preco">Preço do Produto</label>
                    <span class="text-danger">
                        @error('preco')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="form-floating mb-4">
                    <input type="file" class="form-control" name="image" id="image">
                    <span class="text-danger">
                        @error('image')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Cadastrar</button>
                </div>
            </fieldset>
        </form>
    </div>
@endsection