<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;
use App\Support\Lista;

class Saida extends Model {

    const SITUACAO_EM_ELABORACAO  = 1,
          SITUACAO_CONCLUIDA      = 2;

    protected $fillable = ['data', 'hora', 'situacao', 'observacao', 'idpessoa'];

    public function getRules() {
        return Array(
            'data'   => 'required',
            'hora'   => 'required',
            /*'situacao'   => 'required',*/
            'idpessoa'   => 'required|numeric'
        );
    }

    public function getMessageValidate() {
        return Array(
            'data.required'   => 'A data é de preenchimento obrigatório',
            'hora.required'   => 'A hora é de preenchimento obrigatório',
            /*'situacao.required'   => 'Situação não definida',*/
            'idpessoa.required' => 'A pessoa é de preenchimento obrigatório',
            'idpessoa.numeric' => 'O código da pessoa deve ser numérico'
        );
    }

    public function pessoa() {
        return $this->hasOne('App\Model\Pessoa', 'id', 'idpessoa');
    }

    public function getValorTotal() {
        return 0;
    }

    public static function getListaSituacao(string $selecionaSituacao = null) {
        $aLista = Array(
            new Lista(self::SITUACAO_EM_ELABORACAO , 'Em Elaboração'),
            new Lista(self::SITUACAO_CONCLUIDA     , 'Concluída')
        );

        if(is_numeric($selecionaSituacao)) {
            Lista::seleciona($aLista, $selecionaSituacao);
        }

        return $aLista;
    }

    public function getDestricaoSituacao() {
        return Lista::getItem(self::getListaSituacao(), $this->situacao)->getNome();
    }

    public function getDataFomatada() {
        $data = $this->getAttributeFromArray('data');
        if(is_null($data)) {
            return null;
        }

        if(!Carbon::hasFormat($data, 'd/m/Y')) {
            return Carbon::parse($data)->format('d/m/Y');
        }

        return $data;
    }

}
