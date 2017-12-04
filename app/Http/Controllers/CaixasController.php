<?php

namespace casco\Http\Controllers;

use Illuminate\Http\Request;
use casco\Repositories\CaixaDAO;
use casco\Caixa;

class CaixasController extends Controller
{
    protected $caixaDAO;

    public function __construct(CaixaDAO $caixaDAO){
        $this->caixaDAO = $caixaDAO;
    }

    public function formNovo(){
    	$caixas = $this->caixaDAO->buscaTodos();
    	return view('caixa.form_novo_caixa')->with(['caixas'=>$caixas]);
    }

    public function selecionaCaixa(Request $request, $id){
        $request->session()->forget('competencia');
    	$caixa = $this->caixaDAO->busca($id);
        $request->session()->put('caixa',$caixa);
    	return redirect()->route('lancamentos');
    }

    public function novo(Request $request){
        $request->session()->forget('caixa');
        $request->session()->forget('competencia');
        $parametros = $request->only(['nome_caix','descricao_caix']);
    	if ($caixa = $this->caixaDAO->cria($parametros)){
            $request->session()->flash('msg', "Caixa criado: ".$caixa->nome_caix);
            $request->session()->put('caixa',$caixa);
            return redirect()->route('competencia');   
    	}
    	$request->session()->flash('msg', "Erro!");
    	return redirect()->action('CaixasController@formNovo');
    }
}
