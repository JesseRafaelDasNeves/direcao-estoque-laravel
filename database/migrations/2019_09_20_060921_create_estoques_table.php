<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstoquesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('estoques', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('quantidade', 8, 2);

            $table->bigInteger('idproduto')->unique();
            $table->foreign('idproduto', 'fk_produto_estoque')->references('id')->on('produtos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('estoques');
    }
}
