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

}
