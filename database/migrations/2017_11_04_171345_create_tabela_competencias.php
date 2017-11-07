<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabelaCompetencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competencias', function (Blueprint $table) {
            $table->increments('id_comp');
            $table->integer('mes_comp');
            $table->integer('ano_comp');
            $table->float('saldoInicial_comp', 8, 2)->nullable();
            $table->float('saldo_comp', 8, 2)->nullable();
            $table->boolean('bloqueio_comp');
            $table->timestamps();

            $table->integer('idCaixa_comp')->unsigned();
            $table->foreign('idCaixa_comp')->references('id_caix')->on('caixas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competencias');
    }
}
