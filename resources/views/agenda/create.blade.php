
@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h2 class="text-center">Cadastro de data de reserva</h2>
        <hr class="mb-3">
        <div class="row justify-content-evenly">
            <form action="{{ route('agenda.store') }}" method="POST">
                @csrf
                <fieldset>
                    <div class="form-group d-flex mb-4">
                        <div class="form-floating me-5">
                            <input type="date" class="form-control" name="data" id="data" placeholder="">
                            <label for="data">Data</label>

                            <span class="text-danger">
                                @error('data')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
    
                        <div class="form-floating">
                            <input type="time" class="form-control" name="horario" id="horario" placeholder="">
                            <label for="horario">Horário</label>

                            <span class="text-danger">
                                @error('horario')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline-primary">Cadastrar</button>
                </fieldset>
            </form>
        </div>
    </div>
@endsection