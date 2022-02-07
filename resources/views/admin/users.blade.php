@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="row">
        @if (!is_null($clientes))
            <h2 class="mb-4 text-center">Clientes do Restaurante</h2>
            
            <div class="results">
                @if (Session::get('fail'))
                        <div class="alert alert-danger mb-4">
                            {{ Session::get('fail') }}
                        </div>
                @endif

                @if (Session::get('success'))
                    <div class="alert alert-success mb-4">
                        {{ Session::get('success') }}
                    </div>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Email</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">Endereço Principal ou Mais Recente</th>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->id }}</td>
                                <td>{{ $cliente->nome }}</td>
                                <td>{{ $cliente->email }}</td>
                                <td>{{ $cliente->telefone }}</td>

                                @php
                                    $enderecoPrincipal = App\Models\Endereco::where('user_id', '=', $cliente->id)->where('principal', '=', 1)->first();

                                    if (!$enderecoPrincipal) {
                                        $endereco = App\Models\Endereco::where('user_id', '=', $cliente->id)->orderBy('id', 'desc')->first();
                                    } else {
                                        $endereco = $enderecoPrincipal;
                                    }

                                @endphp

                                <td>
                                    @if ($endereco)
                                        {{ $endereco->logradouro }}, {{ $endereco->numero }} - {{ $endereco->bairro }}
                                    @else
                                        Não tem
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                Ainda não existem clientes cadastrados no restaurante
            </div>
        @endif
    </div>
</div>
@endsection