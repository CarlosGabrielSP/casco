<?php

namespace casco;

use Illuminate\Database\Eloquent\Model;

class Competencia extends Model
{
    protected $table = 'competencias';
    protected $primaryKey = 'id_comp';
    protected $guarded = ['id_comp','saldo_comp'];

    public function caixa(){
    	return $this->belongsTo('casco\Caixa','idCaixa_comp');
    }
}
