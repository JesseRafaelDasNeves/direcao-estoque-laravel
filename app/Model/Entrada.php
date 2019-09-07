<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model {

    protected $fillable = ['data_hora', 'numero_nota', 'observacao'];

    public function getRules() {
        return Array(
            'data_hora'   => 'required',
            'numero_nota' => 'required|numeric'
        );
    }

    public function getMessageValidate() {
        return Array(
            'data_hora.required'   => 'A data/hora é de preenchimento obrigatório',
            'numero_nota.required' => 'O número da nota é de preenchimento obrigatório'
        );
    }

}
