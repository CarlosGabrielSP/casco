<?php

namespace casco\Repositories;

use casco\Competencia;

class CompetenciaRepository
{
	protected $competencia;

	public function __construct(Competencia $competencia){
		$this->competencia = $competencia;
	}

	public function cria($parametros){
		return $this->competencia->create($parametros);
	}

	public function busca($id){
		return $this->competencia->find($id);
	}

	public function buscaTodosComFiltro($caixa){
		return $this->competencia->where('idCaixa_comp',$caixa->id_caix)->get();
	}

	public function buscaUltimoComFiltro($caixa){
		return $this->buscaTodosComFiltro($caixa)->last();
	}
}