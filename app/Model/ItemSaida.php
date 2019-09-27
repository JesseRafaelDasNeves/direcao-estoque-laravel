<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ItemSaida extends Model {

    protected $table    = 'itens_saida';
    protected $fillable = ['quantidade', 'valorunitario', 'valortotal', 'idsaida', 'idproduto'];

    public function getRules() {
        return Array(
            'quantidade'    => 'required|numeric',
            'valorunitario' => 'required|numeric',
            'valortotal'    => 'required|numeric',
            'idsaida'       => 'required|numeric',
            'idproduto'     => 'required|numeric'
        );
    }

    public function getMessageValidate() {
        return Array(
            'quantidade.required'    => 'A quantidade é de preenchimento obrigatório',
            'valorunitario.required' => 'Valor unitário é de preenchimento obrigatório',
            'valortotal.required'    => 'Valor total não definido',
            'idsaida.required'       => 'A Saída do item é de preenchimento obrigatório',
            'idproduto.required'     => 'O produto é de preenchimento obrigatório'
        );
    }

    public function getMessageEstoqueInsuficiente(string $sAcao) {
        $qtde        = $this->getAttributeValue('quantidade');
        $qtdeEstoque = $this->produto->getQuantidadeEstoque();
        return "Erro ao $sAcao item saída. Foi informado quantidade ({$this->quantidade}) maior que a disponível no estoque ($qtdeEstoque)";
    }

    public function saida() {
        return $this->hasOne('App\Model\Saida', 'id', 'idsaida');
    }

    public function produto() {
        return $this->hasOne('App\Model\Produto', 'id', 'idproduto');
    }

    public function temEstoqueAtendeQtde() {
        $qtde        = $this->getAttributeValue('quantidade');
        $qtdeEstoque = $this->produto->getQuantidadeEstoque();
        return $qtde <= $qtdeEstoque;
    }

    public function temProdutoFromSaida() {
        $oProduto = $this->where('idsaida'  , '=', $this->idsaida)
                         ->where('idproduto', '=', $this->idproduto)
                         ->first();
        return (bool) $oProduto;
    }

}
