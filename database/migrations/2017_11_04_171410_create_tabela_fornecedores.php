<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabelaFornecedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->increments('id_forn');
            $table->string('nome_forn');
            $table->enum('tipoCadastro_forn', ['cpf','cnpj'])->nullable();
            $table->integer('numCpfCnpj_forn')->nullable();            
            $table->string('endereco_forn')->nullable();
            $table->string('bairro_forn')->nullable();
            $table->string('cidade_forn')->nullable();
            $table->string('uf_forn')->nullable();
            $table->integer('ddd_forn')->nullable();
            $table->integer('telefone_forn')->nullable();
            $table->string('email_forn')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fornecedores');
    }
}
