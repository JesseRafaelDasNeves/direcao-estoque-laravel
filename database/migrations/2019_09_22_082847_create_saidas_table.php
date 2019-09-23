<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaidasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('saidas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('data');
            $table->time('hora');
            $table->enum('situacao', [1,2]);
            $table->text('observacao')->nullable();
            $table->bigInteger('idpessoa');
            $table->timestamps();

            $table->foreign('idpessoa', 'fk_pessoa_saida')->references('id')->on('pessoas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('saidas');
    }
}
