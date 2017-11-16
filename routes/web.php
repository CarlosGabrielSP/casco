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

Route::get('/competencia','CompetenciasController@formNovo')->name('competencia');
Route::post('/competencia/novo','CompetenciasController@novo');
Route::get('/competencia/{id}','CompetenciasController@selecionaCompetencia');

Route::get('teste','CompetenciasController@teste');