<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmOrderMail;
use App\Models\Endereco;
use App\Models\Item;
use App\Models\ItemPedido;
use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{

    public function show($id){

        if(session()->has('LoggedUser')){
            $user = User::find(session('LoggedUser'));
        } else {
            return redirect()->route('home');
        }

        $item = Item::find($id);

        return view('items.show', compact('user', 'item'));
    }

    public function add(Request $request, $id){

        if(session()->has('LoggedUser')){
            $user = User::find(session('LoggedUser'));
        } else {
            return redirect()->route('home');
        }

        $request->validate([
            'quantidade' => 'required|numeric'
        ]);

        if($user->enderecos->isEmpty()){
            return redirect()->back()->with('fail', 'Você precisa cadastrar um endereço antes de fazer um pedido');
        }

        $dados = $request->all();

        $pedidoEmAberto = Pedido::where('finalizado', '=', 0)->where('user_id', '=', $user->id)->first();
        $item = Item::find($id);

        if($pedidoEmAberto){

            $repeticao = 0;
        
            foreach($pedidoEmAberto->items as $produto){
                if($produto->id == $item->id){
                    $repeticao = 1;
                    $itemRepetido = $item;
                }
            }

            if($repeticao){
                $itemPedido = ItemPedido::where('pedido_id', '=', $pedidoEmAberto->id)->where('item_id', '=', $itemRepetido->id)->first();
                $itemPedido->quant += $dados['quantidade'];
                $itemPedido->save();
            } else {
                $dadosPivot['pedido_id'] = $pedidoEmAberto->id;
                $dadosPivot['item_id'] = $item->id;
                $dadosPivot['quant'] = $dados['quantidade'];
                ItemPedido::create($dadosPivot);
            }
        } else {
            $pedido = array();
            $pedido['user_id'] = $user->id;
            $pedido['endereco_id'] = $user->enderecos()->first()->id;
            $pedido = Pedido::create($pedido);
            $novoPedido = Pedido::find($pedido->id);
    
            $dadosPivot['pedido_id'] = $novoPedido->id;
            $dadosPivot['item_id'] = $item->id;
            $dadosPivot['quant'] = $dados['quantidade'];
            ItemPedido::create($dadosPivot);
        }

        return redirect()->route('home')->with('success', $dados['quantidade'] . ' unidades do produto ' . $item->nome . ' estão no seu carrinho !');
    }

    public function confirm($id){

        if(session()->has('LoggedUser')){
            $user = User::find(session('LoggedUser'));
        } else {
            return redirect()->route('home');
        }

        $pedido = Pedido::find($id);
        $total = 0;

        return view('pedidos.confirm', compact('user', 'pedido', 'total'));
    }

    public function close(Request $request, $id){

        $pedido = Pedido::find($id);

        $enderecoId = $request->only(['endereco']);
        $endereco = Endereco::find($enderecoId)->first();
        //dd($endereco);

        
        $pedido->endereco($endereco);
        $pedido->finalizado = 1;
        $pedido->save();

        $user = $pedido->user;

        Mail::to($user->email)->send(new ConfirmOrderMail($user));

        $numero = $endereco->numero ? $endereco->numero : 's/n';

        return redirect()->route('home')->with('success', 'Pedido Fechado. Em breve você o receberá em ' . $endereco->logradouro . ', ' . $numero . ' - ' . $endereco->bairro);
    }
}
