<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DiaHorario;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = User::find(session('LoggedUser'));


        return view('reservas.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find(session('LoggedUser'));

        $request->validate([
            'dataHora' => 'required',
            'convidados' => 'required'
        ]);

        $reserva = $request->only(['dataHora', 'convidados']);
        $reserva['user_id'] = $user->id;
        $salvar = Reserva::create($reserva);

        DiaHorario::where('dataHora', '=', $request->dataHora)->update(['reservado' => 1]);


        if($salvar){
            return redirect()->route('home');
        } else {
            return "Algo deu errado !";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find(session('LoggedUser'));
        $reserva = Reserva::find($id);

        if($user->cannot('update', $reserva)){
            abort('403');
        }

        $diasHorarios = DiaHorario::all();

        if(!$reserva){
            return redirect()->route('reserva.index');
        }

        return view('reservas.edit', compact('user', 'reserva', 'diasHorarios'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find(session('LoggedUser'));
        $reserva = Reserva::find($id);

        if($user->cannot('update', $reserva)){
            abort('403');
        }


        $dados = $request->only(['data', 'horario', 'convidados']);
        $dados['user_id'] = $user->id;

        $reserva->update($dados);

        return redirect()->route('reserva.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find(session('LoggedUser'));
        $reserva = Reserva::find($id);

        if($user->cannot('delete', $reserva)){
            abort('403');
        }

        DiaHorario::where('dataHora', '=', $reserva->dataHora)->update(['reservado' => 0]);
        $reserva->delete();

        return redirect()->route('reserva.index');
    }
}
