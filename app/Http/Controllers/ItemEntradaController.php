<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ItemEntrada;
use App\Support\Lista;
use App\Model\Produto;
use App\Model\Entrada;

class ItemEntradaController extends ControllerBase {

    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    protected function getInstanceModel() {
        return new ItemEntrada();
    }

    protected function getName() {
        return 'item-entrada';
    }

    protected function prefixoRoute() {
        return 'itemEntrada';
    }

    protected function posfixoTitulo() {
        return 'Item Entrada';
    }

    protected function posfixoTituloConsulta() {
        return 'Itens da Entrada ' . request()->route('identrada');
    }

    protected function beforeCreateView(): void {
        parent::beforeCreateView();
        $this->Model->identrada = request()->route('identrada');
    }

    protected function getParamsExtraViewManutencao($oModel): array {
        $aListaProdutos = $this->getListaPodutos();
        Lista::seleciona($aListaProdutos, is_numeric($oModel->idproduto) ? $oModel->idproduto: null);
        return Array(
            'aProdutos' => $aListaProdutos
        );
    }

    protected function getParamsExtraViewConsulta(): array {
        return Array(
            'entrada' => Entrada::find(request()->route('identrada'))
        );
    }

    private function getListaPodutos() {
        $oProdutoBusca = new Produto();
        $aProdutos     = $oProdutoBusca->orderBy('id')->get();
        $aLista        = [];
        foreach ($aProdutos as $oProduto) {
            $aLista[] = new Lista($oProduto->id, $oProduto->nome);
        }
        return $aLista;
    }

    protected function getParamsRoute($oModel): array {
        return Array(
            'identrada' => $oModel->identrada
        );
    }

    public function index($iIdEntrada = null) {
        /* @var $models Model */
        $models = $this->Model->where(['identrada' => $iIdEntrada])->orderBy('id')->paginate(10);
        return $this->loadViewConsulta($models, $this->getParamsExtraViewConsulta());
    }

    public function edit($identrada, $id = null) {
        return parent::edit($id);
    }

    public function show($identrada, $id = null) {
        return parent::show($id);
    }

    public function update(Request $request, $identrada, $id = null) {
        return parent::update($request, $id);
    }

    public function destroy($identrada, $id = null) {
        return parent::destroy($id);
    }

}
