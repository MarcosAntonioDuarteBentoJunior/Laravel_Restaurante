<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\EnderecoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AgendaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [HomeController::class, 'login'])->name('login')->middleware('AlreadyLoggedIn');
Route::get('/register', [HomeController::class, 'register'])->name('register')->middleware('AlreadyLoggedIn');
Route::post('/create', [HomeController::class, 'create'])->name('auth.create');
Route::post('/check', [HomeController::class, 'check'])->name('auth.check');

Route::middleware(['isLogged'])->group(function () {
    
    Route::get('/logout', [HomeController::class, 'logout'])->name('auth.logout');

    Route::post('/reserva/salvar', [ReservaController::class, 'store'])->name('reserva.save');
    Route::get('/minhas-reservas', [ReservaController::class, 'index'])->name('reserva.index');
    Route::delete('/reserva/delete/{id}', [ReservaController::class, 'destroy'])->name('reserva.delete');

    Route::get('/produto/cadastro', [ItemController::class, 'create'])->name('item.create');
    Route::post('/produto/salvar', [ItemController::class, 'store'])->name('item.store');
    Route::get('/produto/editar/{id}', [ItemController::class, 'edit'])->name('item.edit');
    Route::put('/produto/update/{id}', [ItemController::class, 'update'])->name('item.update');
    Route::delete('/produto/delete/{id}', [ItemController::class, 'destroy'])->name('item.destroy');

    Route::get('/endereco/index', [EnderecoController::class, 'index'])->name('endereco.index');
    Route::get('/endereco/cadastro', [EnderecoController::class, 'create'])->name('endereco.create');
    Route::post('/endereco/salvar', [EnderecoController::class, 'store'])->name('endereco.store');
    Route::get('/endereco/editar/{id}', [EnderecoController::class, 'edit'])->name('endereco.edit');
    Route::put('/endereco/update/{id}', [EnderecoController::class, 'update'])->name('endereco.update');
    Route::delete('/endereco/excluir/{id}', [EnderecoController::class, 'destroy'])->name('endereco.destroy');


    Route::get('/carrinho/visualizar/{id}', [CartController::class, 'show'])->name('cart.show');
    Route::post('/carrinho/adicionar/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/carrinho/remover/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/carrinho/confirmar/{id}', [CartController::class, 'confirm'])->name('cart.confirm');
    Route::post('/carrinho/fechar-pedido/{id}', [CartController::class, 'close'])->name('cart.close');

    Route::get('/admin/dashboard/', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/usuarios/meus-dados/', [HomeController::class, 'dados'])->name('user.data');
    Route::get('/usuarios/meus-dados/editar/', [HomeController::class, 'editarDados'])->name('user.edit');
    Route::post('/usuarios/meus-dados/atualizar/', [HomeController::class, 'update'])->name('user.update');

    Route::get('/usuarios/index', [UserController::class, 'index'])->name('user.index');
    Route::get('/usuarios/cadastro/', [UserController::class, 'create'])->name('user.create');

    Route::resource('/agenda', AgendaController::class);
});


