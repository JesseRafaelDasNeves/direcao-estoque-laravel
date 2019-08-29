<?php

namespace App\Http\Controllers;

use App\Model\Pessoa;

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

    protected function posfixoRoute() {
        return 'pessoas';
    }

    protected function getParamsExtraViewManutencao(): array {
        return ['aTipoPessoa' => Pessoa::getListaTipo()];
    }

}
