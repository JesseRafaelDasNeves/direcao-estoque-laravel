<?php

namespace App\Http\Controllers;

use App\Model\Pessoa;
use App\Model;

class PessoaController extends ControllerBase {

    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    protected function getInstanceModel() {
        return new Pessoa();
    }

    protected function getName() {
        return 'pessoa';
    }

    protected function posfixoTitulo() {
        return 'Pessoa';
    }

    protected function prefixoRoute() {
        return 'pessoas';
    }

    protected function getParamsExtraViewManutencao($oModel): array {
        return ['aTipoPessoa' => Pessoa::getListaTipo($oModel->tipo)];
    }

}
