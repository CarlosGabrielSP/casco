<?php

namespace casco;

use Illuminate\Database\Eloquent\Model;

class Fixo extends Model
{
    protected $table = 'fixos';
    protected $primaryKey = 'id_fixo';
    protected $guarded = ['id_fixo'];

    public function caixa(){
    	return $this->belongsTo('casco\Lancamento','idLanc_fixo');
    }
}
