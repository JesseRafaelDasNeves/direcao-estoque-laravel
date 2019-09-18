<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItensEntradaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('itensentrada', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->decimal('quantidade'   , 8, 2);
            $table->decimal('valorunitario', 8, 3);
            $table->decimal('valortotal'   , 8, 2);

            $table->bigInteger('identrada');
            $table->bigInteger('idproduto');

            $table->foreign('identrada', 'fk_entrada_item_entrada')->references('id')->on('entradas');
            $table->foreign('idproduto', 'fk_produto_item_entrada')->references('id')->on('produtos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('itensentrada');
    }
}
