@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            @if (Session::get('fail'))
                <div class="alert alert-danger w-100 text-center">
                    {{ Session::get('fail') }}
                </div>
            @endif
            <form action="{{ route('cart.add', $item->id)}}" method="POST">
                @csrf
                <fieldset>
                    <div id="header" class="justify-content-between d-flex">
                        <div class="col-8">
                            <h2>Quantos {{ $item->nome }} ?</h2>
                            <p class="mt-3">R$ {{ number_format($item->preco, 2, ',', '.') }} cada</p>
                        </div>
                        <div class="col-4">
                            <img src="{{ asset('storage/' . $item->image)}}" alt="" class="img-fluid">
                        </div>
                    </div>
                    <div id="body" class="mt-3 mb-4 form-floating d-flex">
                        <input type="number" class="form-control me-4 w-25" name="quantidade" id="quantidade" min=1 oninput="validity.valid||(value='');" placeholder="">
                        <label for="quantidade">Quantidade</label>
    
                        <div id="button" class="text-center align-self-center">
                            <button type="submit" class="btn btn-outline-success">Adicionar</button>
                        </div>
                    </div>
                    <span class="text-danger">
                        @error('quantidade')
                            {{ $message }}
                        @enderror
                    </span>
                </fieldset>
            </form>
        </div>
    </div>
@endsection