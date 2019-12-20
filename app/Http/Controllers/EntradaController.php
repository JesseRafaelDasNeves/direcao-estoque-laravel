<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Entrada;
use App\Model\ItemEntrada;
use App\Model\Fornecedor;
use App\Model\Estoque;
use Carbon\Carbon;
use App\Support\Lista;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;

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

    protected function prefixoRoute() {
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

    protected function validateUpdate(Request $request, Model $oModel) {
        parent::validateUpdate($request, $oModel);
        return $this->validaSituacaoPermiteManutencao($oModel, 'Alterar');
    }

    protected function validateDestroy(Model $oModel) {
        parent::validateDestroy($oModel);
        return $this->validaSituacaoPermiteManutencao($oModel, 'Excluir');
    }

    private function  validaSituacaoPermiteManutencao(Entrada $oEntrada, string $nomeAcao) {
        if($oEntrada->situacao == Entrada::SITUACAO_CONCLUIDA) {
            return redirect()->route("entradas.index")->withErrors("Erro ao $nomeAcao entrada. Entrada já está concluída");
        }
        return true;
    }

    public function conclui($iId) {
        /* @var $oEntrada Entrada */
        $oEntrada = $this->Model->find($iId);
        $valido   = $this->validaSituacaoPermiteManutencao($oEntrada, 'concluir');

        if($valido instanceof RedirectResponse) {
            return $valido;
        }

        $bOk = $oEntrada->update(['situacao' => Entrada::SITUACAO_CONCLUIDA]);

        if($bOk) {
            $aItens = ItemEntrada::where('identrada', '=', $oEntrada->id)->get();

            foreach ($aItens as $oItemEntrada) {
                /* @var $oEstoqueProduto Estoque */
                $oEstoqueProduto = Estoque::where('idproduto', '=', $oItemEntrada->idproduto)->first();
                $bOk = false;

                if($oEstoqueProduto) {
                    $oEstoqueProduto->addQuantidade($oItemEntrada->quantidade);
                    $bOk = (bool)$oEstoqueProduto->update();
                } else {
                    $oEstoqueProduto = Estoque::create(['quantidade' => $oItemEntrada->quantidade, 'idproduto' => $oItemEntrada->idproduto]);
                    $bOk = (bool) $oEstoqueProduto;
                }

                if($bOk) {
                    $oItemEntrada->setAttribute('idestoque', $oEstoqueProduto->id);
                    $bOk = (bool)$oItemEntrada->update();
                }

                if(!$bOk) {
                    break;
                }
            }
        }

        if($bOk) {
            $currentPage  = request()->get('currentPage', 1);
            $success      = "Entrada concluída com sucesso.";
            return redirect()->route("entradas.index")->with('success', $success);
        }

        return redirect()->route("entradas.index")->withErrors('Erro ao concluir entrada');
    }

}
