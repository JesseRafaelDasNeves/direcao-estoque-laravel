<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItensSaidaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('itens_saida', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->decimal('quantidade'   , 8, 2);
            $table->decimal('valorunitario', 8, 3);
            $table->decimal('valortotal'   , 8, 2);

            $table->bigInteger('idsaida');
            $table->bigInteger('idproduto')->unique();

            $table->foreign('idsaida'  , 'fk_saida_item_saida')->references('id')->on('saidas');
            $table->foreign('idproduto', 'fk_produto_item_saida')->references('id')->on('produtos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('itens_saida');
    }
}
