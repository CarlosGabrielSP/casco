<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabelaLancamentosFixos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('fixos', function (Blueprint $table){
            $table->increments('id_fixo');
            $table->string('competencia_fixo');
            $table->date('vencimento_fixo');
            $table->integer('numeroParcela_fixo')->nullable();
            $table->integer('totalParcelas_fixo')->nullable();
            $table->timestamps();

            $table->integer('idLanc_fixo')->unsigned();
            $table->foreign('idLanc_fixo')->references('id_lanc')->on('lancamentos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fixos');
    }
}
