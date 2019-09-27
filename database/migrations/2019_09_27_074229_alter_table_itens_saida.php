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
            $table->bigInteger('idestoque')->nullable();

            $table->foreign('idestoque', 'fk_estoque_itemsaida')->references('id')->on('estoques');
        });

        $aItensEntrada = App\Model\ItemSaida::all();

        foreach ($aItensEntrada as $oItemSaida) {
            /* @var $oEstoqueProduto Estoque */
            $oEstoqueProduto = App\Model\Estoque::where('idproduto', '=', $oItemSaida->idproduto)->first();

            if($oEstoqueProduto) {
                $oItemSaida->setAttribute('idestoque', $oEstoqueProduto->id);
                $oItemSaida->update();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        if (!Schema::hasTable('itens_saida')) {
            return;
        }

        Schema::table('itens_saida', function (Blueprint $table) {
            $table->dropColumn('idestoque');
        });
    }
}
