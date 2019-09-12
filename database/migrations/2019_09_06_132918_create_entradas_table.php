<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntradasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('entradas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('data');
            $table->time('hora');
            $table->enum('situacao', [1,2]);
            $table->integer('numero_nota');
            $table->text('observacao')->nullable();
            $table->bigInteger('idfornecedor');
            $table->timestamps();

            $table->foreign('idfornecedor', 'fk_fornecedor_entrada')->references('id')->on('fornecedores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('entradas');
    }
}
