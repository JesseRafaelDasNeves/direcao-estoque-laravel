<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    App\Model\Fornecedor,
    App\Support\Lista,
    App\Model\Pessoa;

class FornecedorController extends ControllerBase {

    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    protected function getInstanceModel() {
        return new Fornecedor();
    }

    protected function getName() {
        return 'fornecedor';
    }

    protected function posfixoRoute() {
        return 'fornecedores';
    }

    protected function posfixoTitulo() {
        return 'Fornecedor';
    }

    protected function getParamsExtraViewManutencao($oModel): array {
        $aListaPessoa = $this->getListaPessoas();
        Lista::seleciona($aListaPessoa, is_numeric($oModel->idpessoa) ? $oModel->idpessoa : null);
        return Array(
            'aTipoEmpresa' => $oModel->getListaTipo(is_numeric($oModel->tipo) ? $oModel->tipo : null),
            'aPessoas'     => $aListaPessoa
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

}
