<?php

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

Route::get('/', function () {
    return view('home');
})->name('index');


Route::get('/caixa','CaixasController@formNovo')->name('caixa');
Route::post('/caixa/novo','CaixasController@novo');
Route::get('/caixa/{id}','CaixasController@selecionaCaixa');

Route::get('/competencia','LancamentosController@formNovaCompetencia')->name('competencia');
Route::post('/competencia/novo','LancamentosController@criaPrimeiraCompetencia');
Route::get('/competencia/novo/{mes}/{ano}','LancamentosController@criaProximaCompetencia');
Route::get('/competencia/{mes}/{ano}','LancamentosController@selecionaCompetencia');

Route::get('/lancamentos','LancamentosController@lancamentos')->name('lancamentos');
Route::post('/lancamentos/novo','LancamentosController@novo');
// Route::get('/lancamentos/{id}','LancamentosController@selecionaLancamento');
Route::get('/lancamentos/atualiza','LancamentosController@atualizaSaldosIniciais');

Route::get('teste','LancamentosController@teste');