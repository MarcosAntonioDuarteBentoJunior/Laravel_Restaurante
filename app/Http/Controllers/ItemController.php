<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemPedido;
use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Models\User;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $user = User::find(session('LoggedUser'));

        if($user->cannot('create', Item::class)){
            abort('403');
        }

        return view('items.create', compact('user'));
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

        if($user->cannot('create', Item::class)){
            abort('403');
        }

        $request->validate([
            'nome' => 'required',
            'preco' => 'required',
            'image' => 'required'
            
        ]);

        $image = $request->file('image');
        $uploadedImage = $image->store('items', 'public');

        $data = $request->only(['nome', 'preco']);
        $data['preco'] = str_replace(',', '.', $data['preco']);
        $data['image'] = $uploadedImage;

        $salvar = Item::create($data);

        if($salvar){
            return redirect()->route('dashboard')->with('success', 'Item Cadastrado com Sucesso!');
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
        $item = Item::find($id);

        if($user->cannot('update', $item)){
            abort('403');
        }

        return view('items.edit', compact('user', 'item'));
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
        $item = Item::find($id);

        if($user->cannot('update', $item)){
            abort('403');
        }

        $request->validate([
            'nome' => 'required',
            'preco' => 'required',
            
        ]);

        $image = $request->file('image');

        $data = $request->only(['nome', 'preco']);
        $data['preco'] = str_replace(',', '.', $data['preco']);

        if($image){
            $data['image'] = $image->store('items', 'public');
        } else {
            $data['image'] = $item->image;
        }

        $salvar = $item->update($data);

        if($salvar){
            return redirect()->route('dashboard')->with('success', 'Item Atualizado com Sucesso!');
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
        $item = Item::find($id);

        if($user->cannot('delete', $item)){
            abort('403');
        }

        $pedidos = Pedido::where('finalizado', '=', 0)->get();
        $pedidosItem = 0;

        foreach($pedidos as $pedido){

            $busca = ItemPedido::where('pedido_id', '=', $pedido->id)->where('item_id', '=', $item->id)->first();

            if($busca){
                $pedidosItem++;
            }
        }

        if($pedidosItem){
            return redirect()->back()->with('fail', 'Este produto não pode ser excluído pois existem ' . $pedidosItem . ' pedidos em aberto contendo ele!');
        } else {
            $item->delete();
            return redirect()->route('dashboard')->with('success', 'O produto ' . $item->nome . ' foi exclído com sucesso!');
        }
    }
}
