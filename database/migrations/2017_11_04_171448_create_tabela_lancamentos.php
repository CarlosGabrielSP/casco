<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabelaLancamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lancamentos', function (Blueprint $table) {
            $table->increments('id_lanc');
            $table->enum('tipo_lanc', ['receita','despesa']);
            $table->float('valor_lanc', 8, 2);
            $table->date('data_lanc');
            $table->text('descricao_lanc');
            // $table->date('vencimento_lanc')->nullable();
            // $table->boolean('fixo');
            // $table->integer('parcela_lanc')->nullable();
            // $table->integer('totalParcelas_lanc')->nullable();
            $table->timestamps();

            $table->integer('idCaixa_lanc')->unsigned();
            $table->integer('idFornecedor_lanc')->unsigned()->nullable();

            $table->foreign('idCaixa_lanc')->references('id_caix')->on('caixas')->onDelete('cascade');
            $table->foreign('idFornecedor_lanc')->references('id_forn')->on('fornecedores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lancamentos');
    }
}
