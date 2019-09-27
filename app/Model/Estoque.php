<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Estoque extends Model {

    protected $fillable = ['quantidade', 'idproduto'];

    public function getRules() {
        return Array(
            'quantidade' => 'required|numeric',
            'idproduto'  => 'required|numeric'
        );
    }

    public function produto() {
        return $this->hasOne('App\Model\Produto', 'id', 'idproduto');
    }

    public function addQuantidade(float $qtdeAdd) {
        $quantidadeAtual = $this->getAttributeValue('quantidade');
        $this->setAttribute('quantidade', ($quantidadeAtual + $qtdeAdd));
    }

    public function retiraQuantidade(float $qtde) {
        $quantidadeAtual = $this->getAttributeValue('quantidade');
        $this->setAttribute('quantidade', ($quantidadeAtual - $qtde));
    }

}
