<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ItemSaida;
use App\Support\Lista;
use App\Model\Produto;
use App\Model\Saida;
use Illuminate\Database\Eloquent\Model;

class ItemSaidaController extends ControllerBase {

    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    protected function getInstanceModel() {
        return new ItemSaida();
    }

    protected function getName() {
        return 'item-saida';
    }

    protected function posfixoTitulo() {
        return 'Item Saída';
    }

    protected function prefixoRoute() {
        return 'itemSaida';
    }

    protected function posfixoTituloConsulta() {
        return 'Itens da Saída ' . request()->route('idsaida');
    }

    protected function beforeCreateView(): void {
        parent::beforeCreateView();
        $this->Model->idsaida = request()->route('idsaida');
    }

    protected function getParamsExtraViewManutencao($oModel): array {
        if(isset($oModel->idproduto) && ($oModel->idproduto > 0) && ($this->getCodigoAcao() != self::FORM_INCLUIR)) {
            $oModel->setAttribute('quantidadeEstoque', $oModel->produto->getQuantidadeEstoque());
        }

        $aListaProdutos = $this->getListaPodutos();
        Lista::seleciona($aListaProdutos, is_numeric($oModel->idproduto) ? $oModel->idproduto: null);
        return Array(
            'aProdutos' => $aListaProdutos
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

    protected function getParamsExtraViewConsulta(): array {
        return Array(
            'saida' => Saida::find(request()->route('idsaida'))
        );
    }

    protected function getParamsRoute($oModel): array {
        return Array(
            'idsaida' => $oModel->idsaida
        );
    }

    public function index($idsaida = null) {
        /* @var $models ItemSaida */
        $models = $this->Model->where(['idsaida' => $idsaida])->orderBy('id')->paginate(10);
        return $this->loadViewConsulta($models, $this->getParamsExtraViewConsulta());
    }

    public function edit($idsaida, $id = null) {
        return parent::edit($id);
    }

    public function show($idsaida, $id = null) {
        return parent::show($id);
    }

    public function update(Request $request, $idsaida, $id = null) {
        return parent::update($request, $id);
    }

    public function destroy($idsaida, $id = null) {
        return parent::destroy($id);
    }

    protected function validateStore(Request $request, Model $oModel) {
        $oValido = parent::validateStore($request, $oModel);

        if($oValido && !$oModel->temEstoqueAtendeQtde()) {
            $oValido = redirect()->back()->withErrors($oModel->getMessageEstoqueInsuficiente('Incluir'))->withInput($request->all());
        }

        if($oValido && $oModel->temProdutoFromSaida()) {
            $oValido = redirect()->back()->withErrors('Esse produto já foi informado')->withInput($request->all());
        }

        return $oValido;
    }

    protected function validateUpdate(Request $request, Model $oModel) {
        $oValido =  parent::validateUpdate($request, $oModel);
        if($oValido && !$oModel->temEstoqueAtendeQtde()) {
            $oValido = redirect()->route('itemSaida.edit', ['idsaida' => $oModel->idsaida, 'itemSaida' => $oModel->id])
                                ->withErrors($oModel->getMessageEstoqueInsuficiente('Alterar'))
                                ->withInput($request->all());
        }

        return $oValido;
    }

    public function getQtdeEstoqueProduto($idSaida, $idProduto) {
        $oProduto = Produto::find($idProduto);
        return $oProduto ? $oProduto->getQuantidadeEstoque() : 0;
    }

}
