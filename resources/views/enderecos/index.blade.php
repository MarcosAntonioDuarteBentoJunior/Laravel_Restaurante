@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            @if (!$user->enderecos->isNotEmpty())
                <div class="alert alert-info">Você ainda não cadastrou nenhum endereço !</div>   
            @else
                <h2 class="text-center">Endereços Cadastrados</h2>
                <hr class="mb-3">

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

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Logradouro</th>
                            <th scope="col">Número</th>
                            <th scope="col">Bairro</th>
                            <th scope="col">Principal</th>
                            <th scope="col">Opções</th>
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
                                    <td>
                                        <a href="{{ route('endereco.edit', $endereco->id)}}" class="me-3 text-decoration-none"><i class="fas fa-pencil-alt" title="Editar"></i></a>
    
                                        <!-- Ativa o modal -->
                                        <a href="#" type="button" class="text-decoration-none text-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $endereco->id }}" title="Excluir endereco">
                                            <i class="fas fa-eraser"></i>
                                        </a>
                                        
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal{{ $endereco->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Confirmar Ação</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Deseja realmente excluir o endereco {{ $endereco->logradouro }}, {{ $endereco->numero }} - {{ $endereco->bairro }}  ? Todos os pedidos vinculados a ele serão excluídos da base de dados.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
                                                        <form action="{{ route('endereco.destroy', $endereco->id)}}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger">Confirmar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            <div class="mt-4">
                <a href="{{ route('endereco.create') }}" class="btn btn-success">Novo Endereço</a>
            </div>
        </div>
    </div>
@endsection