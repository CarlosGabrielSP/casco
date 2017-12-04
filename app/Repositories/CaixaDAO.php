<?php 

namespace casco\Repositories;

use casco\Caixa;

class CaixaDAO
{
	private $caixa;

	public function __construct(Caixa $caixa){
		$this->caixa = $caixa;
	}

	public function cria($parametros){
		return $this->caixa->create($parametros);
	}

	public function busca($id){
		return $this->caixa->find($id);
	}

	public function buscaTodos(){
		return $this->caixa->all();
	}
}