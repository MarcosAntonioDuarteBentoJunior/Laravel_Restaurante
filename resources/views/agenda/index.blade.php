@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            @if (!$diasHorarios->isNotEmpty())
                <div class="alert alert-info">Não existem datas para reserva !</div>   
            @else
                <h2 class="text-center">Datas e Horários disponíveis para reserva</h2>
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
                            <th scope="col">Data e Horário</th>
                            <th scope="col">Reservado</th>
                            <th scope="col">Aberta em</th>
                            <th scope="col">Opções</th>
                        </thead>
                        <tbody>
                            @foreach ($diasHorarios as $diaHorario)
                                <tr>
                                    <td>{{ date('d/m/Y H:i', strtotime($diaHorario->dataHora)) }}</td>
                                    <td>
                                        @if ($diaHorario->reservado)
                                            <span class="text-success">Sim</span>
                                        @else
                                            <span class="text-danger">Não</span>
                                        @endif
                                    </td>
                                    <td>{{ date('d/m/Y H:i', strtotime($diaHorario->created_at)) }}</td>
                                    <td>    
                                        <!-- Ativa o modal -->
                                        <a href="#" type="button" class="text-decoration-none text-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $diaHorario->id }}" title="Excluir data">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal{{ $diaHorario->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Confirmar Ação</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Deseja realmente excluir a data de reserva @php echo date('d/m/Y H:i', strtotime($diaHorario->dataHora)) @endphp ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
                                                        <form action="{{ route('agenda.destroy', $diaHorario->id) }}" method="POST">
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
                <a href="{{ route('agenda.create') }}" class="btn btn-success">Nova data de reserva</a>
            </div>
        </div>
    </div>
@endsection