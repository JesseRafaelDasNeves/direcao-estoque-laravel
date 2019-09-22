<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Model\ItemEntrada;
use App\Model\Estoque;

class AlterTableItensentrada extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('itensentrada')) {
            return;
        }

        Schema::table('itensentrada', function (Blueprint $table) {
            $table->bigInteger('idestoque')->nullable();

            $table->foreign('idestoque', 'fk_estoque_itementrada')->references('id')->on('estoques');
        });

        $aItensEntrada = ItemEntrada::all();

        foreach ($aItensEntrada as $oItemEntrada) {
            /* @var $oEstoqueProduto Estoque */
            $oEstoqueProduto = Estoque::where('idproduto', '=', $oItemEntrada->idproduto)->first();

            if($oEstoqueProduto) {
                $oItemEntrada->setAttribute('idestoque', $oEstoqueProduto->id);
                $oItemEntrada->update();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        if (!Schema::hasTable('itensentrada')) {
            return;
        }

        Schema::table('itensentrada', function (Blueprint $table) {
            $table->dropColumn('idestoque');
        });
    }
}
