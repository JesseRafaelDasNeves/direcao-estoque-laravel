<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Saida;
use App\Model\Pessoa;
use App\Model\ItemSaida;
use App\Model\Estoque;
use App\Support\Lista;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SaidaController extends ControllerBase {

    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    protected function getInstanceModel() {
        return new Saida();
    }

    protected function getName() {
        return 'saida';
    }

    protected function posfixoTitulo() {
        return 'Saída';
    }

    protected function prefixoRoute() {
        return 'saidas';
    }

    protected function getParamsExtraViewManutencao($oModel): array {
        $aListaPessoa = $this->getListaPessoas();
        Lista::seleciona($aListaPessoa, is_numeric($oModel->idpessoa) ? $oModel->idpessoa : null);
        return Array(
            'aPessoas' => $aListaPessoa
        );
    }

    private function getListaPessoas() {
        $oPessoa  = new Pessoa();
        $aPessoas = $oPessoa->orderBy('nome')->get();
        $aLista   = [];
        foreach ($aPessoas as $oPessoa) {
            $aLista[] = new Lista($oPessoa->id, $oPessoa->nome);
        }
        return $aLista;
    }

    protected function beforeCreateView(): void {
        parent::beforeCreateView();
        if(empty(old('data'))) {
            $this->Model->setAttribute('data', now()->toDateString());
        }
        if(empty(old('hora'))) {
            $this->Model->setAttribute('hora', now()->toTimeString());
        }
    }

    protected function executeCreate(Request $request) {
        return $this->Model->create(array_merge(['situacao' => Saida::SITUACAO_EM_ELABORACAO], $request->all()));
    }

    public function store(Request $request) {
        return parent::store($request);
    }

    private function  validaSituacaoPermiteManutencao(Saida $oSaida, string $nomeAcao) {
        if($oSaida->situacao == Saida::SITUACAO_CONCLUIDA) {
            return redirect()->route("saidas.index")->withErrors("Erro ao $nomeAcao. Saída já está concluída");
        }
        return true;
    }

    public function conclui($id) {
        /* @var $oSaida Saida */
        $oSaida = $this->Model->find($id);
        $valido = $this->validaSituacaoPermiteManutencao($oSaida, 'concluir');
        $sMotivoErro = null;

        if($valido instanceof RedirectResponse) {
            return $valido;
        }

        DB::beginTransaction();

        $bOk = $oSaida->update(['situacao' => Saida::SITUACAO_CONCLUIDA]);

        if($bOk) {
            $aItens = ItemSaida::where('idsaida', '=', $oSaida->id)->get();

            foreach ($aItens as $oItemSaida) {
                /* @var $oEstoque Estoque */
                $oEstoque = Estoque::where('idproduto', '=', $oItemSaida->idproduto)->first();
                $bOk = false;

                if($oEstoque && ($oEstoque->quantidade >= $oItemSaida->quantidade)) {
                    $oEstoque->retiraQuantidade($oItemSaida->quantidade);
                    $bOk = (bool)$oEstoque->update();
                } else {
                    $bOk = false;
                    if($oEstoque && ($oEstoque->quantidade < $oItemSaida->quantidade)) {
                        $sMotivoErro = "Estoque do produto {$oItemSaida->idproduto} é insuficiente. Em estoque: {$oEstoque->quantidade}, Solicitada: {$oItemSaida->quantidade}";
                    } else {
                        $sMotivoErro = "Estoque do produto {$oItemSaida->idproduto} não foi encontado";
                    }
                }

                if($bOk) {
                    $oItemSaida->setAttribute('idestoque', $oEstoque->id);
                    $bOk = (bool)$oItemSaida->update();
                }

                if(!$bOk) {
                    break;
                }
            }
        }

        if($bOk) {
            DB::commit();
            $currentPage  = request()->get('currentPage', 1);
            $success      = "Saída concluída com sucesso.";
            return redirect()->route("saidas.index")->with('success', $success);
        }

        DB::rollBack();
        return redirect()->route("saidas.index")->withErrors("Erro ao concluir saída. $sMotivoErro");
    }

}
