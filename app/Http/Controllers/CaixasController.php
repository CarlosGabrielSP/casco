<?php

namespace casco\Http\Controllers;

use Illuminate\Http\Request;
use casco\Caixa;

class CaixasController extends Controller
{
    public function formNovoCaixa(){
    	$caixas = $this->puxaTodosCaixas();
    	//dd($caixas);
    	return view('caixa.form_novo_caixa')->with(['caixas'=>$caixas]);
    }
    public function selecionaCaixa(Request $request, $id){
    	$caixa = $this->puxaCaixa($id);
    	$request->session()->put('caixa',$caixa);
    	return back();
    }

    public function puxaTodosCaixas(){
    	return Caixa::all();
    }
    public function puxaCaixa($id){
    	return Caixa::find($id);
    }

    public function novoCaixa(Request $request){
    	if ($caixa = Caixa::create($request->only(['nome_caix','descricao_caix']))) {
    		$request->session()->flash('msg', "Caixa criado: ".$caixa->nome_caix);
    		$request->session()->put('caixa',$caixa);
    	}else{
    		$request->session()->flash('msg', "Erro!");
    	}
    	return back();
    }
}
