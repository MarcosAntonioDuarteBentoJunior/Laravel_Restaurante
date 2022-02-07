@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="row">
            @if ($produtos->isNotEmpty())
                <h2 class="mb-4 text-center">Produtos do Restaurante</h2>
                
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
                            <th scope="col">Foto</th>
                            <th scope="col">Nome do Produto</th>
                            <th scope="col">Preço</th>
                            <th scope="col">Opções</th>
                        </thead>
                        <tbody>
                            @foreach ($produtos as $item)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="" class="img-fluid w-25">
                                    </td>
                                    <td>{{ $item->nome }}</td>
                                    <td>R$ {{ number_format($item->preco, 2, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('item.edit', $item->id)}}" class="me-3 text-decoration-none"><i class="fas fa-pencil-alt" title="Editar"></i></a>
    
                                            <!-- Ativa o modal -->
                                            <a href="#" type="button" class="text-decoration-none text-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}" title="Excluir item">
                                                <i class="fas fa-eraser"></i>
                                            </a>
                                            
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Confirmar Ação</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Deseja realmente excluir o item {{ $item->nome }} ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
                                                            <form action="{{ route('item.destroy', $item->id) }}" method="POST">
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
                    <div class="d-flex justify-content-center">
                        {!! $produtos->links() !!}
                    </div>
                </div>
            @else
                <div class="alert alert-info">
                    Ainda não existem produtos cadastrados no restaurante
                </div>
            @endif
        </div>
    </div>
@endsection