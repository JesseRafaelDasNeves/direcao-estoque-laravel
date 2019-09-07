<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Entrada;

class EntradaController extends ControllerBase {

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

}
