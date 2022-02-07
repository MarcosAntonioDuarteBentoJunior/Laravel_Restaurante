<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $user = User::find(session('LoggedUser'));

        if($user->role != 'admin'){
            abort('403');
        }

        $clientes = User::all();

        return view('admin.users', compact('user', 'clientes'));
    }
}
