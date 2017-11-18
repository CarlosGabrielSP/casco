<?php

namespace casco\Http\Controllers;

use Illuminate\Http\Request;
use casco\Repositories\CompetenciaRepository;

class LancamentosController extends Controller
{
    public function lancamentos(CompetenciaRepository $compRepositorio, Request $request){
    	if (!$request->session()->has('caixa')){
    		$request->session()->flash('msg','Selecione um Caixa');
			return redirect()->action('CaixasController@formNovo');
		}
		$competencias = $compRepositorio->buscaTodosComFiltro($request->session()->get('caixa'));
    	return view('lancamento.lancamentos')->with('competencias',$competencias);
    }
}
