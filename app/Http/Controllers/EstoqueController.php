<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Model\Estoque;

/**
 * Description of EstoqueController
 *
 * @author Jessé Rafael das Neves
 */
class EstoqueController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function movimentacoes() {
        $estoques      = $this->getEstoques();
        $movimentacoes = [];

        foreach ($estoques as $estoque) {
            $movimentacoes[$estoque->id] = $this->getMovimentacoesByEstoque($estoque);
        }

        return view('movimentacoes-estoque', ['estoques' => $estoques, 'movimentacoes' => $movimentacoes]);
    }

    private function getEstoques() {
        return \App\Model\Estoque::select(['id','quantidade','idproduto'])->orderBy('id', 'asc')->get();
    }

    private function getMovimentacoesByEstoque(Estoque $estoque) {
        $saidas = DB::table('itens_saida')
            ->select([
                'itens_saida.id',
                'itens_saida.quantidade AS qtde_movimentada',
                'itens_saida.valorunitario',
                'itens_saida.valortotal',
                DB::raw("'Saída' AS tipo"),
                'saidas.data',
                'saidas.hora',
            ])
            ->join('saidas', 'saidas.id', '=', 'itens_saida.idsaida')
            ->where('itens_saida.idestoque', '=', $estoque->id);

        return DB::table('itensentrada')
            ->select([
                'itensentrada.id',
                'itensentrada.quantidade AS qtde_movimentada',
                'itensentrada.valorunitario',
                'itensentrada.valortotal',
                DB::raw("'Entrada' AS tipo"),
                'entradas.data',
                'entradas.hora',
            ])
            ->join('entradas', 'entradas.id', '=', 'itensentrada.identrada')
            ->where('itensentrada.idestoque', '=', $estoque->id)
            ->union($saidas)
            ->orderBy('data')
            ->get();
    }

}
