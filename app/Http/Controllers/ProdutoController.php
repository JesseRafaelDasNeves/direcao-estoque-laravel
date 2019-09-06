<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Model\Produto;

class ProdutoController extends ControllerBase {

    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    protected function getInstanceModel() {
        return new Produto();
    }

    protected function getName() {
        return 'produto';
    }

    protected function posfixoRoute() {
        return 'produtos';
    }

    protected function posfixoTitulo() {
        return 'Produto';
    }

    protected function getParamsExtraViewManutencao($oModel): array {
        return Array(
            'aCategoria' => $oModel->getListaCategoria(isset($oModel->categoria) ? $oModel->categoria: null),
            'aUnidade'   => $oModel->getListaUnidade(is_numeric($oModel->unidade) ? $oModel->unidade: null)
        );
    }

}
