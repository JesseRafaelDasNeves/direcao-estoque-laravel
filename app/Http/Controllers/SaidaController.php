<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Saida;
use App\Model\Pessoa;
use App\Support\Lista;
use Illuminate\Database\Eloquent\Model;

class SaidaController extends ControllerBase {

    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    protected function getInstanceModel() {
        return new Saida();
    }

    protected function getName() {
        return 'saida';
    }

    protected function posfixoTitulo() {
        return 'Saída';
    }

    protected function prefixoRoute() {
        return 'saidas';
    }

    protected function getParamsExtraViewManutencao($oModel): array {
        $aListaPessoa = $this->getListaPessoas();
        Lista::seleciona($aListaPessoa, is_numeric($oModel->idpessoa) ? $oModel->idpessoa : null);
        return Array(
            'aPessoas' => $aListaPessoa
        );
    }

    private function getListaPessoas() {
        $oPessoa  = new Pessoa();
        $aPessoas = $oPessoa->orderBy('nome')->get();
        $aLista   = [];
        foreach ($aPessoas as $oPessoa) {
            $aLista[] = new Lista($oPessoa->id, $oPessoa->nome);
        }
        return $aLista;
    }

    protected function beforeCreateView(): void {
        parent::beforeCreateView();
        if(empty(old('data'))) {
            $this->Model->setAttribute('data', now()->toDateString());
        }
        if(empty(old('hora'))) {
            $this->Model->setAttribute('hora', now()->toTimeString());
        }
    }

    protected function executeCreate(Request $request) {
        return $this->Model->create(array_merge(['situacao' => Saida::SITUACAO_EM_ELABORACAO], $request->all()));
    }

    public function store(Request $request) {
        return parent::store($request);
    }

}
