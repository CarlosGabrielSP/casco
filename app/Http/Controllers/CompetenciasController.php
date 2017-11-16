<?php

namespace casco\Http\Controllers;

use Illuminate\Http\Request;
use casco\Repositories\CompetenciaRepository;
use casco\Competencia;


class CompetenciasController extends Controller
{
    public function formNovo(CompetenciaRepository $compRepositorio, Request $request){
    	if (!$request->session()->has('caixa')){
    		$request->session()->flash('msg','Selecione um Caixa');
			return redirect()->action('CaixasController@formNovo');
		}
		$competencias = $compRepositorio->buscaTodosComFiltro($request->session()->get('caixa'));
		// dd($competencias);
    	return view('competencia.form_nova_comp')->with('competencias',$competencias);
    }

    public function novo(CompetenciaRepository $compRepositorio, Request $request){
    	if (!$request->session()->has('caixa')){
    		$request->session()->flash('msg','Antes de criar um Competência nova, seleciona um caixa');
			return redirect()->action('CaixasController@formNovo');
		}

    	$parametros = $request->only(['mes_comp','ano_comp','saldoInicial_comp']);
    	$parametros['bloqueio_comp'] = FALSE;
    	$parametros['idCaixa_comp'] = $request->session()->get('caixa.id_caix');

    	if($competencia = $compRepositorio->cria($parametros)){
    		$request->session()->put('competencia',$competencia);
    		$request->session()->flash('msg','Competencia: '.$competencia->mes_comp.'/'.$competencia->ano_comp.' criada!');
    	}else {
    		$request->session()->flash('msg','Erro ao criar competência');
    	}
    	return redirect()->route('index');
    }

    public function selecionaCompetencia(CompetenciaRepository $compRepositorio,Request $request,$id){
    	$competencia = $compRepositorio->busca($id); 
    	$request->session()->put('competencia',$competencia);
    	return back();
    }

    public function novoProximo(Request $request){
    	$competencia_atual = $request->session()->get('competencia');
    	$compProxima = $this->proxima_comp($request);
    }

    public function proxima_comp(Request $request){
    	$ano_atual = $request->session()->get('competencia.ano_comp');
    	$mes_atual = $request->session()->get('competencia.mes_comp');
    	if($mes_atual==12){
    		return ['mes_comp'=>01,'ano_comp'=>$ano_atual+1];
    	}
    	return return ['mes_comp'=>$mes_atual+1,'ano_comp'=>$ano_atual];
    }
}
