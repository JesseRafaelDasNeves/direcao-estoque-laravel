<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Fornecedor;

class FornecedorController extends ControllerBase {


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
        return ['aTipoEmpresa' => $oModel->getListaTipo($oModel->tipo)];
    }

}
