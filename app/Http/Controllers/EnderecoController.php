<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EnderecoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(session()->has('LoggedUser')){
            $user = User::find(session('LoggedUser'));
        } else {
            return redirect()->route('home');
        }

        return view('enderecos.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $user = User::find(session('LoggedUser'));

        if($user->enderecos->count() > 5){
            return redirect()->route('endereco.index')->with('fail', 'Você pode cadastrar no máximo 5 endereços!');
        }

        return view('enderecos.create', compact('user'));
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
            'logradouro' => 'required',
            'bairro' => 'required',
        ]);

        $data = $request->only(['logradouro', 'numero', 'bairro', 'user_id', 'principal']);

        $salvar = Endereco::create($data);

        if($salvar){
            return redirect()->route('endereco.index')->with('success', 'Novo Endereço Cadastrado Com Sucesso !');
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
        $endereco = Endereco::find($id);

        if($user->cannot('update', $endereco)){
            abort('403');
        }

        return view('enderecos.edit', compact('user', 'endereco'));
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
        $request->validate([
            'logradouro' => 'required',
            'bairro' => 'required',
        ]);
        
        $endereco = Endereco::find($id);

        $data = $request->only(['logradouro', 'numero', 'bairro', 'principal', 'user_id']);
        $endereco->update($data);

        if($endereco){
            return redirect()->route('endereco.index')->with('success', 'Dados Atualizados Com Sucesso !');
        } else {
            return "Algo deu errado !";
        }
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
        $pedidos = DB::table('pedidos')->where('endereco_id', '=', $id)->where('finalizado', '=', 0)->count();
        $endereco = Endereco::find($id);

        if($user->cannot('delete', $endereco)){
            abort('403');
        }

        if($pedidos){
            return back()->with('fail', 'Este endereço não pode ser excluído pois existem ' . $pedidos . ' pedido(s) em aberto associados a ele !');
        }

        $endereco->delete();
        
        return redirect()->route('endereco.index')->with('success', 'Endereço Excluído Com Sucesso !');
    }
}
