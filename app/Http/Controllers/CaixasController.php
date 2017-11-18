<?php

namespace casco\Http\Controllers;

use Illuminate\Http\Request;
use casco\Repositories\CaixaRepository;
use casco\Repositories\CompetenciaRepository;
use casco\Caixa;

class CaixasController extends Controller
{
    public function formNovo(CaixaRepository $caixaRepositorio){
    	$caixas = $caixaRepositorio->buscaTodos();
    	return view('caixa.form_novo_caixa')->with(['caixas'=>$caixas]);
    }

    public function selecionaCaixa(CompetenciaRepository $compRepositorio, CaixaRepository $caixaRepositorio, Request $request, $id){
    	$caixa = $caixaRepositorio->busca($id);
        $request->session()->put('caixa',$caixa);
        if($competencia = $compRepositorio->buscaUltimoComFiltro($caixa)){
            $request->session()->put('competencia',$competencia);
        }else{
            $request->session()->forget('competencia');
        }
    	return redirect()->action('LancamentosController@lancamentos');
    }

    public function novo(CompetenciaRepository $compRepositorio, CaixaRepository $caixaRepositorio, Request $request){
        $parametros = $request->only(['nome_caix','descricao_caix']);
    	if ($caixa = $caixaRepositorio->cria($parametros)){
            $this->selecionaCaixa($compRepositorio,$caixaRepositorio,$request,$caixa->id_caix);
            $request->session()->flash('msg', "Caixa criado: ".$caixa->nome_caix);
            return redirect()->action('CompetenciasController@formNovo');   
    	}
    	$request->session()->flash('msg', "Erro!");
    	return redirect()->action('CaixasController@formNovo');
    }
}
