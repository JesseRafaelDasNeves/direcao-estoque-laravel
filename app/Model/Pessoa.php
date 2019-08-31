<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Support\Lista;

class Pessoa extends Model {

    const TIPO_FISICA   = 1,
          TIPO_JURIDICA = 2;

    protected $fillable = ['nome', 'cpfcnpj', 'tipo'];

    public function getRules() {
        return Array(
            'nome'    => 'required|min:3|max:200',
            'tipo'    => 'required|numeric',
            'cpfcnpj' => 'required'
        );
    }

    public function getMessageValidate() {
        return Array(
            'nome.required'    => 'O nome é de preenchimento obrigatório',
            'nome.min'         => 'O nome deve ter ao menos 3 caracteres',
            'nome.max'         => 'O nome deve ter no máximo 200 caracteres',
            'tipo.required'    => 'O Tipo é de preenchimento obrigatório',
            'tipo.numeric'     => 'O Tipo deve ser número',
            'cpfcnpj.required' => 'O CPF/CNPJ é de preenchimento obrigatório'
        );
    }

    public static function getListaTipo(int $iTipo = null) {
        $aLista = Array(
            new Lista(self::TIPO_FISICA  , 'Física'),
            new Lista(self::TIPO_JURIDICA, 'Jurídica')
        );

        if(is_numeric($iTipo)) {
            Lista::seleciona($aLista, $iTipo);
        }

        return $aLista;
    }

}
