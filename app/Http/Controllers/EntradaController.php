<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Entrada;
use App\Model\Fornecedor;
use \Carbon\Carbon;
use App\Support\Lista;

class EntradaController extends ControllerBase {

    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    protected function getInstanceModel() {
        return new Entrada();
    }

    protected function getName() {
        return 'entrada';
    }

    protected function posfixoRoute() {
        return 'entradas';
    }

    protected function posfixoTitulo() {
        return 'Entrada';
    }

    protected function executeCreate(Request $request) {
        return $this->Model->create(array_merge(['situacao' => 1], $request->all()));
    }

    protected function getParamsExtraViewManutencao($oModel): array {
        $aListaFornecedor = $this->getListaFornecedores();
        Lista::seleciona($aListaFornecedor, is_numeric($oModel->idfornecedor) ? $oModel->idfornecedor: null);
        return Array(
            'aFornecedores' => $aListaFornecedor
        );
    }

    private function getListaFornecedores() {
        $oFornecedorBusca = new Fornecedor();
        $aFornecedores    = $oFornecedorBusca->orderBy('id')->get();
        $aLista           = [];
        foreach ($aFornecedores as $oFornecedor) {
            $aLista[] = new Lista($oFornecedor->id, $oFornecedor->getPessoa()->nome);
        }
        return $aLista;
    }

}
