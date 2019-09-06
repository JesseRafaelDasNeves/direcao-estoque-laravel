<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Support\Lista;

class Produto extends Model {

    const UNIDADE           = 1,
          UNIDADE_LITRO     = 2,
          UNIDADE_KILOGRAMA = 3,
          UNIDADE_SACO      = 4,
          UNIDADE_CAIXA     = 5;

    const CATEGORIA_LIMPEZA         = 'limpeza',
          CATEGORIA_CONSTRUCAO      = 'construcao',
          CATEGORIA_ESCRITORIO      = 'escritorio',
          CATEGORIA_REMEDIO         = 'remedio',
          CATEGORIA_MOVEIS          = 'moveis',
          CATEGORIA_ELETRODOMESTICO = 'eletrodomestico',
          CATEGORIA_ESCOLAR         = 'escolar';

    protected $fillable = ['nome', 'unidade', 'categoria', 'descricao'];

    public function getRules() {
        return Array(
            'nome'      => 'required|min:3|max:150',
            'unidade'   => 'required|numeric',
            'categoria' => 'required'
        );
    }

    public function getMessageValidate() {
        return Array(
            'nome.required'      => 'O nome é de preenchimento obrigatório',
            'nome.min'           => 'O nome deve ter ao menos 3 caracteres',
            'nome.max'           => 'O nome deve ter no máximo 200 caracteres',
            'unidade.required'   => 'A unidade é de preenchimento obrigatório',
            'unidade.numeric'    => 'A unidade deve ser número',
            'categoria.required' => 'A categoria é de preenchimento obrigatório'
        );
    }

    public static function getListaUnidade(int $unidade = null) {
        $aLista = Array(
            new Lista(self::UNIDADE          , 'UN'),
            new Lista(self::UNIDADE_LITRO    , 'LT'),
            new Lista(self::UNIDADE_KILOGRAMA, 'KL'),
            new Lista(self::UNIDADE_SACO     , 'SC'),
            new Lista(self::UNIDADE_CAIXA    , 'CX')
        );

        if(is_numeric($unidade)) {
            Lista::seleciona($aLista, $unidade);
        }

        return $aLista;
    }

    public static function getListaCategoria(string $categoria = null) {
        $aLista = Array(
            new Lista(self::CATEGORIA_LIMPEZA        , 'Limpeza'),
            new Lista(self::CATEGORIA_CONSTRUCAO     , 'Construção'),
            new Lista(self::CATEGORIA_ESCRITORIO     , 'Escritório'),
            new Lista(self::CATEGORIA_REMEDIO        , 'Remédio'),
            new Lista(self::CATEGORIA_MOVEIS         , 'Móveis'),
            new Lista(self::CATEGORIA_ELETRODOMESTICO, 'Elétrodomestico'),
            new Lista(self::CATEGORIA_ESCOLAR        , 'Escolar')
        );

        if(!empty($categoria)) {
            Lista::seleciona($aLista, $categoria);
        }

        return $aLista;
    }

    public function getDestricaoUnidade() {
        return Lista::getItem(self::getListaUnidade(), $this->unidade)->getNome();
    }

    public function getDestricaoCategoria() {
        return Lista::getItem(self::getListaCategoria(), $this->categoria)->getNome();
    }

}
