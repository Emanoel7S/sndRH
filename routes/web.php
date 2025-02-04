<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FullCalenderController;
use App\Http\Controllers\Auth\FuncionarioController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmpresasController;
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


Auth::routes(['register' => false]);


Route::get('/', 'DashboardController@index')->name('Dash');
Route::get('/home', 'DashboardController@index')->name('Home');


Route::any('/dashboard', 'DashboardController@index');
Route::get('meuperfil', 'HomeController@meuperfil');

Route::get('adiantamentos', 'AdiantamentosController@index');
Route::get('adiantamentos/novo', 'AdiantamentosController@novo');
Route::post('adiantamentos/novo', 'AdiantamentosController@insert');
//Route::get('adiantamentos/editar/{id}', 'AdiantamentosController@editar');
//Route::post('adiantamentos/editar', 'AdiantamentosController@update');
Route::get('adiantamentos/cancel/{id}', 'AdiantamentosController@remove')->where('id','[0-9]+');

Route::get('ferias', 'FeriasController@index');
Route::get('ferias/novo', 'FeriasController@novo');
Route::post('ferias/novo', 'FeriasController@insert');
//Route::get('ferias/editar/{id}', 'FeriasController@editar');
//Route::post('ferias/editar', 'FeriasController@update');
Route::get('ferias/cancel/{id}', 'FeriasController@remove')->where('id','[0-9]+');

Route::controller(ConveniosController::class)->group(function () {
    Route::get('convenios', 'index');
    Route::get('convenios/novo', 'novo');
    Route::post('convenios/novo', 'insert');
    Route::get('convenios/cancel/{id}', 'remove')->where('id','[0-9]+');
});



//Rotas usuario
Route::prefix('users')->group(function () {
    Route::get('/novo', [UserController::class, 'create'])->name('users.create'); // Exibe o formulário de cadastro
    Route::post('/store', [UserController::class, 'store'])->name('users.store'); // Processa o cadastro do usuário
    Route::get('/', [UserController::class, 'index'])->name('users.index'); // Lista os usuários cadastrados
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});



//Rotas cargo
Route::prefix('cargos')->group(function () {
    Route::get('/novo', [CargoController::class, 'create'])->name('cargo.create'); // Exibe o formulário de cadastro
    Route::post('/store', [CargoController::class, 'store'])->name('cargos.store'); // Processa o cadastro do cargos
    Route::get('/', [CargoController::class, 'index'])->name('cargos.index'); // Lista os cargos cadastrados
    Route::get('/cargos/{id}/edit', [CargoController::class, 'edit'])->name('cargos.edit');
    Route::delete('/cargos/{id}', [CargoController::class, 'destroy'])->name('cargos.destroy');
});


//Rotas empresa
Route::get('/empresas', [EmpresasController::class, 'index'])->name('empresas.index');
Route::get('/empresas/novo', [EmpresasController::class, 'create'])->name('empresas.novo');
Route::get('/empresas/{idComp}/editar', [EmpresasController::class, 'edit'])->name('empresas.edit'); // Rota de edição
Route::post('/empresas', [EmpresasController::class, 'store'])->name('empresas.store');
Route::delete('/empresas/{idComp}', [EmpresasController::class, 'destroy'])->name('empresas.destroy');


Route::get('check', 'FeriasController@autoCheck');







