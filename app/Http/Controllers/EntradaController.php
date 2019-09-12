<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Entrada;
use \Carbon\Carbon;

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

}
