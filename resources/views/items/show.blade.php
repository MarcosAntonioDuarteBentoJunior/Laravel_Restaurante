@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        @if (Session::get('fail'))
            <div class="alert alert-danger w-100 text-center">
                {{ Session::get('fail') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 mb-4 mb-md-0 align-self-center">
                <form action="{{ route('cart.add', $item->id)}}" method="POST">
                    @csrf
                    <fieldset class="text-center">
                        <div>
                            <h2>Quantos {{ $item->nome }} ?</h2>
                            <p class="mt-3">R$ {{ number_format($item->preco, 2, ',', '.') }} cada</p>
                        </div>
                        <div class="mt-3 mb-4">
                            <input type="number" class="form-control w-50 mx-auto p-3" name="quantidade" id="quantidade" min=1 oninput="validity.valid||(value='');" placeholder="Quantidade">
                            <span class="text-danger">
                                @error('quantidade')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="text-centerr">
                            <button type="submit" class="btn btn-outline-success">Adicionar</button>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="col-12 col-md-6 text-center">
                <img src="{{ asset('storage/' . $item->image)}}" alt="" class="img-fluid w-50 h-100 align-self-center justify-content-center mx-auto">
            </div>
        </div>
    </div>
@endsection