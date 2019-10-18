<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableItensSaida extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('itens_saida')) {
            return;
        }

        Schema::table('itens_saida', function (Blueprint $table) {
            $table->dropUnique('itens_saida_idproduto_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {}

}
