@extends('layouts.app')

@section('content')
    <div class="container py-3 mt-3">
        <h2 class="text-center">Informações do Pedido</h2>
        <hr class="mb-3">
        <div class="row">
            <div class="col-12 mb-3">
                <label class="mb-2">Nome:</label>
                <input type="text"  class="form-control" readonly value="{{ $user->nome }}">
            </div>
            <div class="d-flex justify-content-between mb-4">
                <div>
                    <label class="mb-2">E-mail:</label>
                    <input type="email" class="form-control" readonly value="{{ $user->email }}">
                </div>
                <div>
                    <label class="mb-2">Telefone:</label>
                    <input type="tel" class="form-control" readonly value="{{ $user->telefone }}">
                </div>
            </div>
            <h3 class="text-center">Produtos</h3>
            <hr class="mb-3">

            <div class="mt-4 table-responsive">
                <table class="table table-borderless align-middle">
                    <thead>
                        <th scope="col">Foto</th>
                        <th scope="col">Item</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Quantidade</th>
                    </thead>

                    <tbody>
                        @foreach ($pedido->items as $item)
                            @php
                                $itemPedido = App\Models\ItemPedido::where('pedido_id', '=', $pedido->id)->where('item_id', '=', $item->id)->first();
                                $total += $itemPedido->quant * $item->preco;
                            @endphp

                            <tr>
                                <td>
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="" class="img-fluid w-25">
                                </td>
                                <td>
                                    {{ strtoupper($item->nome) }}
                                </td>
                                <td>
                                    R$ {{ number_format($item->preco, 2, ',', '.') }}
                                </td>
                                <td>
                                    {{ $itemPedido->quant }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <h4 class="fw-bold mt-2 mb-4">Total: R$ {{ number_format($total, 2, ',', '.') }}</h4>
            <h3 class="mt-4 text-center">Endereços</h3>
            <hr class="mb-3">
            <form action="{{ route('cart.close', $pedido->id) }}" method="POST">
                @csrf
                @foreach ($user->enderecos as $endereco)
                    <div>
                        <div class="form-check">
                            <input class="form-check-input" name="endereco" class="form-control" type="radio" @if ($endereco->principal == 1) checked @endif value="{{ $endereco->id }}" id="flexCheckDefault{{ $endereco->id }}">
                            <label class="form-check-label ps-2" for="flexCheckDefault{{ $endereco->id }}">
                                {{ $endereco->logradouro }}, {{ $endereco->numero }} - {{ $endereco->bairro }}
                            </label>
                        </div>
                    </div>
                @endforeach         
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success">Fechar Pedido</button>
                    </div>
            </form>
        </div>
    </div>
@endsection