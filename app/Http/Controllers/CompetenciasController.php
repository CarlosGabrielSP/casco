<?php

namespace casco\Http\Controllers;

use Illuminate\Http\Request;
use casco\Repositories\CompetenciaRepository;
use casco\Competencia;


class CompetenciasController extends Controller
{	
	protected $compRepositorio;

	public function __construct(CompetenciaRepository $compRepositorio){
		$this->compRepositorio = $compRepositorio;
	}

    public function formNovo(Request $request){
    	if (!$request->session()->has('caixa')){
    		$request->session()->flash('msg','Selecione um Caixa');
			return redirect()->action('CaixasController@formNovo');
		}
    	return view('competencia.form_nova_comp');
    }

    public function selecionaCompetencia(Request $request,$id){
    	$competencia = $this->compRepositorio->busca($id); 
    	$request->session()->put('competencia',$competencia);
    	return redirect()->action('LancamentosController@lancamentos');
    }

    public function novo(Request $request){
    	if (!$request->session()->has('caixa')){
    		$request->session()->flash('msg','Antes de criar um Competência nova, seleciona um caixa');
			return redirect()->action('CaixasController@formNovo');
		}
    	$parametros = $request->only(['mes_comp','ano_comp','saldoInicial_comp']);
    	$parametros['bloqueio_comp'] = FALSE;
    	$parametros['idCaixa_comp'] = $request->session()->get('caixa.id_caix');
    	if(!$competencia = $this->compRepositorio->cria($parametros)){
    		$request->session()->flash('msg','Erro ao criar competência');
    		return redirect()->route('index');
    	}
    	$request->session()->flash('msg','Competencia: '.$competencia->mes_comp.'/'.$competencia->ano_comp.' criada!');
    	$request->session()->put('competencia',$competencia);
		return redirect()->action('LancamentosController@lancamentos');
    }

    public function novoProximo(Request $request){
    	if (!$request->session()->has('caixa')){
    		$request->session()->flash('msg','Selecione um Caixa');
			return redirect()->action('CaixasController@formNovo');
		}
		$caixa = $request->session()->get('caixa');
    	if(!$compUltima = $this->compRepositorio->buscaUltimoComFiltro($caixa)){
    		return redirect()->action('CompetenciasController@formNovo');
	    }
	    $compProxima = $this->proximoCompetencia($request);
    	$compProxima['saldoInicial_comp'] = $compUltima->saldoInicial_comp;
    	$compProxima['saldo_comp'] = $compUltima->saldoInicial_comp;
    	$compProxima['bloqueio_comp'] = FALSE;
    	$compProxima['idCaixa_comp'] = $compUltima->idCaixa_comp;
    	if (!$competencia = $this->compRepositorio->cria($compProxima)){
    		$request->session()->flash('msg','Erro!');
    		return redirect()->route('index');
    	}
    	$request->session()->flash('msg','Competencia: '.$competencia->mes_comp.'/'.$competencia->ano_comp.' criada!');
    	$request->session()->put('competencia',$competencia);
		return redirect()->action('LancamentosController@lancamentos');
    }

    public function proximoCompetencia(Request $request){
    	if (!$request->session()->has('caixa')){
    		$request->session()->flash('msg','Selecione um Caixa');
			return redirect()->action('CaixasController@formNovo');
		}
    	if (!$request->session()->has('competencia')){
    		$request->session()->flash('msg','Selecione um Competencia');
			return redirect()->action('CompetenciasController@formNovo');
		}
    	$ano_atual = $request->session()->get('competencia.ano_comp');
    	$mes_atual = $request->session()->get('competencia.mes_comp');
    	if($mes_atual==12){
    		return ['mes_comp'=>01,'ano_comp'=>$ano_atual+1];
    	}
    	return ['mes_comp'=>$mes_atual+1,'ano_comp'=>$ano_atual];
    }
}
