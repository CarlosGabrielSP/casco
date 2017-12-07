<?php

namespace casco\Http\Controllers;

use Illuminate\Http\Request;
use casco\Repositories\LancamentoDAO;
use casco\Lancamento;

class LancamentosController extends Controller
{
	protected $lancamentoDAO;

	public function __construct(LancamentoDAO $lancamentoDAO){
		$this->lancamentoDAO = $lancamentoDAO;
	}

    public function lancamentos(Request $request){
    	if(!$request->session()->has('caixa')){
    		$request->session()->flash('msg','Selecione um Caixa');
			return redirect()->action('CaixasController@formNovo');
		}
		$caixa = $request->session()->get('caixa');
		$competencias = $this->lancamentoDAO->buscaTodasCompetencias($caixa->id_caix);
		if(!$competencias->count()){
			$request->session()->flash('msg','Crie uma Competencia');
			return redirect()->route('competencia');
		}
		if($request->session()->has('competencia')){
			$competencia = $request->session()->get('competencia');
		}else{
			$competencia = $competencias->last()->mes_ano;
			$request->session()->put('competencia',$competencia);
		}
		$lancamentos = $this->lancamentoDAO->buscaTodosComFiltro($caixa->id_caix,$competencia);
		$saldoTotal = $lancamentos->sum('valor_lanc');
		$primeiro_lanc = $lancamentos->shift();
    	return view('lancamento.lancamentos')->with([
		    									'lancamentos'=>$lancamentos,
		    									'competencias'=>$competencias,
		    									'saldo_total'=>$saldoTotal,
		    									'saldo_inicial'=>$primeiro_lanc->valor_lanc]);
    }

    public function novo(Request $request){
    	if (!$request->session()->has('caixa')){
    		$request->session()->flash('msg','Selecione um Caixa');
			return redirect()->action('CaixasController@formNovo');
		}
		$caixa = $request->session()->get('caixa');
		$parametros = $request->only(['tipo_lanc','fixo_lanc','data_lanc','descricao_lanc','valor_lanc','cor_lanc']);
		$parametros['idCaixa_lanc'] = $caixa->id_caix;
		if($parametros['tipo_lanc'] == "despesa") $parametros['valor_lanc'] *= -1;
		if($this->lancamentoDAO->cria($parametros)){
			$this->atualizaSaldosIniciais($caixa);
			return back();
		}else{
			$request->session()->flash('msg','Erro!');
			return redirect()->route('index');
		}
    }

    public function remover(Request $request, $id){
    	$lancamento = $this->lancamentoDAO->busca($id);
    	$caixa = $request->session()->get('caixa');
    	if ($this->lancamentoDAO->excluir($id)){
    		$request->session()->flash(
    			'msg',$lancamento->descricao_lanc.' | '.$lancamento->data_lanc.' | '.$lancamento->valor_lanc.'. Foi excluido.'
    		);
    		$this->atualizaSaldosIniciais($caixa);
    	}else{
    		$request->session()->flash('msg','Erro!');
    	}
    	return back();
    }

    public function alterar(Request $request, $id){
    	$caixa = $request->session()->get('caixa');
    	$lancamento = $this->lancamentoDAO->busca($id);
    	$parametros = $request->only(['tipo_lanc','data_lanc','descricao_lanc','valor_lanc']);
    	if ($this->lancamentoDAO->atualizar($id,$parametros)){
    		$request->session()->flash(
    			'msg',$lancamento->descricao_lanc.' | '.$lancamento->data_lanc.' | '.$lancamento->valor_lanc.'. Foi alterado.'
    		);
    		$this->atualizaSaldosIniciais($caixa);
    	}else{
    		$request->session()->flash('msg','Erro!');
    	}
    	return back();
    }

// =========================================================================================================

    public function selecionaCompetencia(Request $request, $mes, $ano){
    	$competencia = $mes.'/'.$ano;
    	$request->session()->put('competencia',$competencia);
    	return redirect()->route('lancamentos');
    }

    public function formNovaCompetencia(Request $request){
    	if (!$request->session()->has('caixa')){
    		$request->session()->flash('msg','Selecione um Caixa');
			return redirect()->action('CaixasController@formNovo');
		}
    	return view('competencia.form_nova_comp');
    }

    public function criaPrimeiraCompetencia(Request $request){
    	if (!$request->session()->has('caixa')){
    		$request->session()->flash('msg','Selecione um Caixa');
			return redirect()->action('CaixasController@formNovo');
		}
		$caixa = $request->session()->get('caixa');
		$data = $request->ano.'-'.$request->mes.'-01';
		$parametros = array();
		$parametros['tipo_lanc'] = 'receita';
		$parametros['data_lanc'] = $data;
		$parametros['descricao_lanc'] = '****SALDO_INICIAL****';
		$parametros['valor_lanc'] = $request->saldoInicial;
		$parametros['idCaixa_lanc'] = $caixa->id_caix;
		if($this->lancamentoDAO->cria($parametros)){
			return redirect()->route('lancamentos');
		}else{
			$request->session()->flash('msg','Erro!');
			return redirect()->route('index');
		}
    }

    public function criaProximaCompetencia(Request $request, $mes, $ano){
    	if (!$request->session()->has('caixa')){
    		$request->session()->flash('msg','Selecione um Caixa');
			return redirect()->action('CaixasController@formNovo');
		}
		$caixa = $request->session()->get('caixa');
		if($mes==12){
    		$proxAno = $ano+1;
    		$data = $proxAno.'-01-01';
    		$proximaCompetencia = '01/'.$proxAno;
    	}else{
    		$proxMes = str_pad($mes+1,2,0,STR_PAD_LEFT);
    		$data = $ano.'-'.$proxMes.'-01';
    		$proximaCompetencia = $proxMes.'/'.$ano;
    	}
		$parametros = array();
		$parametros['tipo_lanc'] = 'receita';
		$parametros['data_lanc'] = $data;
		$parametros['descricao_lanc'] = '****SALDO_INICIAL****';
		$parametros['valor_lanc'] = $this->lancamentoDAO->somaValoresComFiltro($caixa->id_caix,$mes.'/'.$ano);
		$parametros['idCaixa_lanc'] = $caixa->id_caix;
		if($this->lancamentoDAO->cria($parametros)){
			$request->session()->put('competencia',$proximaCompetencia);
			return redirect()->route('lancamentos');
		}else{
			$request->session()->flash('msg','Erro!');
			return redirect()->route('index');
		}
    }

    public function removerUltimaCompetencia(Request $request){
        if (!$request->session()->has('caixa')){
            $request->session()->flash('msg','Selecione um Caixa');
            return redirect()->action('CaixasController@formNovo');
        }
        $caixa = $request->session()->get('caixa');
        $competencia = $this->lancamentoDAO->buscaTodasCompetencias($caixa->id_caix)->last();
        $this->lancamentoDAO->excluiCompetencia($caixa->id_caix,$competencia->mes_ano);
        $request->session()->forget('competencia');
        return redirect()->route('lancamentos');
    }

    public function atualizaSaldosIniciais($caixa){
    	$competencias = $this->lancamentoDAO->buscaTodasCompetencias($caixa->id_caix);
    	$i=0;
    	$soma=0;
    	foreach ($competencias as $comp){
    		$lancamentos = $this->lancamentoDAO->buscaTodosComFiltro($caixa->id_caix,$comp->mes_ano);
    		if($i){
    			$primeiro_lanc = $lancamentos->first();
    			$primeiro_lanc->update(['valor_lanc'=>$soma]);
    		}
    		$soma = $lancamentos->sum('valor_lanc');
    		$i++;
    	}
    	return redirect()->route('lancamentos');
    }
    // public function definirProxCompetencia($mes, $ano){
    // 	if($mes[0]==12){
    // 		$proxAno = $ano+1;
    // 		// $data = $proxAno.'-01-01';
    // 		return '01/'.$proxAno;
    // 	}else{
    // 		$proxMes = str_pad($mes+1,2,0,STR_PAD_LEFT);
    // 		// $data = $ano.'-'.$proxMes.'-01';
    // 		return $proxMes.'/'.$ano;
    // 	}
    // }

// =========================================================================================================

    public function teste(Request $request){
    	$caixa = $request->session()->get('caixa');
    	$ultimaCompetencia = $this->lancamentoDAO->buscaTodasCompetencias($caixa->id_caix)->last();
    	$competencia = explode('/',$ultimaCompetencia->mes_ano);
    	if($competencia[0]==12){
    		$proxAno = $competencia[1]+1;
    		return "01/".$proxAno;
    	}else{
    		$proxMes = $competencia[0]+1;
    		return $proxMes.'/'.$competencia[1];
    	}
    }
}