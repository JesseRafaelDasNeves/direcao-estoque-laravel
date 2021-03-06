<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;
use App\Support\Lista;

class Entrada extends Model {

    const SITUACAO_EM_ELABORACAO  = 1,
          SITUACAO_CONCLUIDA      = 2;

    protected $fillable = ['data', 'hora', 'situacao', 'numero_nota', 'observacao', 'idfornecedor'];

    public function getRules() {
        return Array(
            'data'   => 'required',
            'hora'   => 'required',
            /*'situacao'   => 'required',*/
            'idfornecedor'   => 'required|numeric',
            'numero_nota' => 'required|numeric'
        );
    }

    public function getMessageValidate() {
        return Array(
            'data.required'   => 'A data é de preenchimento obrigatório',
            'hora.required'   => 'A hora é de preenchimento obrigatório',
            /*'situacao.required'   => 'Situação não definida',*/
            'numero_nota.required' => 'O número da nota é de preenchimento obrigatório',
            'idfornecedor.required' => 'O fonecedor é de preenchimento obrigatório',
            'idfornecedor.numeric' => 'O código do fonecedor deve ser numérico'
        );
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

    public function fornecedor() {
        return $this->hasOne('App\Model\Fornecedor', 'id', 'idfornecedor');
    }

    public function getValorTotal() {
        return ItemEntrada::where(['identrada' => $this->id])->sum('valortotal');
    }

}
