<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiaHorario;
use App\Models\User;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(session('LoggedUser'));

        if($user->cannot('viewAny', DiaHorario::class)){
            abort('403');
        }

        $diasHorarios = DiaHorario::paginate(7);

        return view('agenda.index', compact('user', 'diasHorarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::find(session('LoggedUser'));

        if($user->cannot('create', DiaHorario::class)){
            abort('403');
        }

        return view('agenda.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'data' => 'required',
            'horario' => 'required'
        ]);


        $data = $request->only('data');
        $horario = $request->only('horario');

        $dataHorario = implode($data) . " " . implode($horario);

        $data = array();
        $data['dataHora'] = date('Y-m-d H:i', strtotime($dataHorario));

        $reserva = DiaHorario::create($data);

        if($reserva){
            return redirect()->route('agenda.index')->with('success', 'Dta de reserva cadastrada com sucesso!');
        } else {
            abort('500');
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
        //
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
        //
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

        if($user->cannot('create', DiaHorario::class)){
            abort('403');
        }
        
        $diaHorario = DiaHorario::find($id);

        if($diaHorario->reservado){
            return redirect()->route('agenda.index')->with('fail', 'Esta data esta reservada e não pode ser excluída!');
        }

        $diaHorario->delete();
        return redirect()->route('agenda.index')->with('success', 'Reserva removida com sucesso!');
    }
}
