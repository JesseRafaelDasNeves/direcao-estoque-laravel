<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ItemEntrada extends Model {

    protected $table    = 'itensentrada';
    protected $fillable = ['quantidade', 'valorunitario', 'valortotal', 'identrada', 'idproduto'];

    public function getRules() {
        return Array(
            'quantidade'    => 'required|numeric',
            'valorunitario' => 'required|numeric',
            'valortotal'    => 'required|numeric',
            'identrada'     => 'required|numeric',
            'idproduto'     => 'required|numeric'
        );
    }

    public function getMessageValidate() {
        return Array(
            'quantidade.required'    => 'A quantidade é de preenchimento obrigatório',
            'valorunitario.required' => 'Valor unitário é de preenchimento obrigatório',
            'valortotal.required'    => 'Valor total não definido',
            'identrada.required'     => 'A Entrada do item é de preenchimento obrigatório',
            'idproduto.required'     => 'O produto é de preenchimento obrigatório'
        );
    }

    public function entrada() {
        return $this->hasOne('App\Model\Entrada', 'id', 'identrada');
    }

    public function produto() {
        return $this->hasOne('App\Model\Produto', 'id', 'idproduto');
    }

}
