<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model {

    protected $fillable = ['tipo'];

    public function getRules() {
        return Array(
            'tipo' => 'required|numeric'
        );
    }

    public function getMessageValidate() {
        return Array(
            'tipo.required' => 'O Tipo é de preenchimento obrigatório',
            'tipo.numeric'  => 'O Tipo deve ser número'
        );
    }
}
