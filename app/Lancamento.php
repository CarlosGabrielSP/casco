<?php

namespace casco;

use Illuminate\Database\Eloquent\Model;

class Lancamento extends Model
{
    protected $table = 'lancamentos';
    protected $primaryKey = 'id_lanc';
    protected $guarded = ['id_lanc'];

    public function caixa(){
    	return $this->belongsTo('casco\Caixa','idCaixa_lanc');
    }
}
