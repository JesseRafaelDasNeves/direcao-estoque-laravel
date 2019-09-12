<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model,
    \App\Support\Lista;

class Fornecedor extends Model {

    const TIPO_GRANDE_PORTE  = 1,
          TIPO_PEQUENO_PORTE = 2,
          TIPO_MEDIO_PORTE   = 3,
          TIPO_MICRO         = 4;

    /** @var Pessoa */
    private $Pessoa;

    protected $table    = 'fornecedores';
    protected $fillable = ['tipo', 'inscricaoestadual', 'idpessoa'];

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

    public function getPessoa() {
        if(is_null($this->idpessoa)) {
            return new Pessoa();
        }
        if(!isset($this->Pessoa)) {
            $this->Pessoa = (new Pessoa())->find($this->idpessoa);
        }
        return $this->Pessoa;
    }

    public static function getListaTipo(int $selecionaTipo = null) {
        $aLista = Array(
            new Lista(self::TIPO_GRANDE_PORTE , 'Grande Porte'),
            new Lista(self::TIPO_PEQUENO_PORTE, 'Pequeno Porte'),
            new Lista(self::TIPO_MEDIO_PORTE  , 'Médio Porte'),
            new Lista(self::TIPO_MICRO        , 'Micro')
        );

        if(is_numeric($selecionaTipo)) {
            Lista::seleciona($aLista, $selecionaTipo);
        }

        return $aLista;
    }

    public function getDestricaoTipo() {
        return Lista::getItem(self::getListaTipo(), $this->tipo)->getNome();
    }

    public function pessoa() {
        return $this->hasOne('App\Model\Pessoa', 'id', 'idpessoa');
    }

}
