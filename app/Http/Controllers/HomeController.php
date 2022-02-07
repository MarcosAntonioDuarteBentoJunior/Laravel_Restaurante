<?php

namespace App\Http\Controllers;

use App\Mail\UserSignedMail;
use App\Models\DiaHorario;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Pedido;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $diasHorarios = DiaHorario::where('reservado', '=', '0')->get();
        $pratosPopulares = DB::table('items')->limit(6)->get();
        $especialidades = DB::table('items')->orderBy('id', 'DESC')->limit(6)->get();

        if(session()->has('LoggedUser')){
            $user = User::find(session('LoggedUser'));
            $pedidoEmAberto = Pedido::where('finalizado', '=', 0)->where('user_id', '=', $user->id)->first();

            return view('home', compact('user', 'diasHorarios', 'pratosPopulares', 'pedidoEmAberto', 'especialidades'));
        }

        $user = null;
        $pedidoEmAberto = null;
        return view('home', compact('user', 'diasHorarios', 'pratosPopulares', 'pedidoEmAberto', 'especialidades'));
    }

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function create(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:users',
            'senha' => 'required|min:5|max:12',
            'telefone' => 'required'
        ]);

        
        $data = $request->only(['nome', 'email', 'senha', 'telefone']);
        $data['senha'] = Crypt::encrypt($data['senha']);
        $save = User::create($data);

        if($save) {
            $user = User::find($save->id)->first();
            Mail::to($user->email)->send(new UserSignedMail($user));

            return back()->with('success', 'Usuario cadastrado com sucesso !');
        } else {
            return back()->with('fail', 'Algo deu errado');
        }
    }

    public function check(Request $request){

        $request->validate([
            'email' => 'required|email',
            'senha' => 'required|min:5|max:12'
        ]);

        $user = User::where('email', '=', $request->email)->first();

        if($user && Crypt::decrypt($user->senha) ==  $request->senha){
            $request->session()->put('LoggedUser', $user->id);
            return redirect()->route('home');

        } else {
            return back()->with('fail', 'Usuário ou senha incorretos');
        }
    }

    public function dashboard(){
        $user = User::find(session('LoggedUser'));
        $produtos = Item::paginate(4);

        return view('admin.dashboard', compact('user', 'produtos'));
    }

    public function dados(){

        $user = User::find(session('LoggedUser'));

        return view('admin.user-data', compact('user'));

    }

    
    public function editarDados(){

        $user = User::find(session('LoggedUser'));

        return view('admin.user-data-edit', compact('user'));

    }

    public function update(Request $request){

        $request->validate([
            'nome' => 'required',
            'email' => 'required|email',
            'telefone' => 'required',
            'senhaAtual' => 'required'
        ]);

        
        $user = User::find(session('LoggedUser'));

        if(!(Crypt::decrypt($user->senha) ==  $request->senhaAtual)){
            return redirect()->route('user.edit')->with('fail', 'Senha atual incorreta!');
        }

        $data = $request->only(['nome', 'email', 'telefone']);

        if($request->novaSenha){
            $data['senha'] = Crypt::encrypt($request->novaSenha);
        } else {
            $data['senha'] = $user->senha;
        }

        $user->update($data);

        return redirect()->route('user.data')->with('success', 'Dados atualizados com sucesso!');
    }


    public function logout(){
        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            return redirect()->route('home');
        }
    }
}
