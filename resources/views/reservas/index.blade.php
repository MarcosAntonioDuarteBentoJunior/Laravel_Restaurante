@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            @if (!$user->reservas->isNotEmpty())
                <div class="alert alert-info">Você ainda não fez nehuma reserva !</div>   
            @else
                <div class="container">
                    <h2 class="text-center">Minhas Reservas</h2>
                    <hr class="mb-3">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <th scope="col">Número da reserva</th>
                                    <th scope="col">Data e Horário</th>
                                    <th scope="col">Número de convidados</th>
                                    <th scope="col">Reserva feita em:</th>
                                    <th scope="col">Ultima alteração</th>
                                    <th scope="col">Opções</th>
                                </thead>
                                <tbody>
                                    @foreach ($user->reservas as $reserva)
                                        <tr>
                                            <td>{{$reserva->id}}</td>
                                            <td>{{date('d/m/Y H:i', strtotime($reserva->dataHora))}}</td>
                                            <td>{{$reserva->convidados}}</td>
                                            <td>{{date('d/m/Y H:i:s', strtotime($reserva->created_at))}}</td>
                                            <td>{{date('d/m/Y H:i:s', strtotime($reserva->updated_at))}}</td>
                                            <td>
                                                <!-- Ativa o modal -->
                                                <a href="#" type="button" class="text-decoration-none text-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $reserva->id }}" title="Excluir Reserva">
                                                    <i class="fas fa-eraser"></i>
                                                </a>
                                                
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal{{ $reserva->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Confirmar Ação</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Deseja realmente excluir a reserva de {{ date('d/m/Y H:i', strtotime($reserva->dataHora)) }} ?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
                                                                <form action="{{ route('reserva.delete', $reserva->id)}}" method="POST">
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
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection