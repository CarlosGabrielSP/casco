<?php

namespace casco;

use Illuminate\Database\Eloquent\Model;

class Caixa extends Model
{
    protected $table = 'caixas';
    protected $primaryKey = 'id_caix';
    protected $fillable = ['nome_caix','descricao_caix'];

    public function competencia(){
    	return $this->hasMany('casco\Competencia');
    }
}
