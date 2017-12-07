<?php 

namespace casco\Repositories;

use casco\Lancamento;
use Illuminate\Support\Facades\DB;

class LancamentoDAO
{
	protected $lancamento;

	public function __construct(Lancamento $lancamento){
		$this->lancamento = $lancamento;
	}

	public function cria($parametros){
		return $this->lancamento->create($parametros);
	}

	public function busca($id){
		return $this->lancamento->find($id);
	}

	public function atualizar($id,$parametros){
		return $this->lancamento->find($id)->update($parametros);
	}

	public function excluir($id){
		return $this->lancamento->find($id)->delete();
	}

	public function buscaTodos($idCaixa){
		return $this->lancamento->where('idCaixa_lanc',$idCaixa)
								->orderBy('data_lanc')
								->get();
	}

	public function buscaTodosComFiltro($idCaixa,$competencia){
		$competenciaSql = substr(date('Y-m-d', strtotime(strtr('01/'.$competencia,'/','-'))),0,7);
		return $this->lancamento->where('idCaixa_lanc',$idCaixa)
								->where('data_lanc','like',$competenciaSql.'%')
								->orderBy('data_lanc')
								->get();
	}

	public function somaValoresComFiltro($idCaixa,$competencia){
		return $this->buscaTodosComFiltro($idCaixa,$competencia)->sum('valor_lanc');
	}

	public function buscaPorColuna($idCaixa,$competencia,$coluna,$conteudo){
		$competenciaSql = substr(date('Y-m-d', strtotime(strtr('01/'.$competencia,'/','-'))),0,7);
		return $this->lancamento->where('idCaixa_lanc',$idCaixa)
								->where('data_lanc','like',$competenciaSql.'%')
								->where($coluna,$conteudo)
								->orderBy('data_lanc')
								->get();
	}

	// =============================================

	public function buscaTodasCompetencias($id_caix){
		$competencias = DB::select("SELECT DISTINCT strftime('%m', data_lanc) || '/' || strftime('%Y', data_lanc) AS mes_ano FROM lancamentos WHERE idCaixa_lanc = $id_caix");
		return collect($competencias);
	}

	public function excluiCompetencia($idCaixa,$competencia){
		$competencias = $this->buscaTodosComFiltro($idCaixa,$competencia);
		foreach ($competencias as $comp) {
			$comp->delete();
		}
	}
}