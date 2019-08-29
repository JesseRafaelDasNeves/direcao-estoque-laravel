<?php

namespace App\Http\Controllers;

use App\Model;

/**
 * Description of ControllerBase
 *
 * @author Jessé Rafael das Neves
 */
abstract class ControllerBase extends Controller {

    /** @var Model */
    protected $Model;

    private $acao;

    const FORM_INCLUIR = 10,
          FORM_ALTERAR = 11,
          FORM_EXCLUIR = 12;

    public function __construct() {
        $this->loadCodigoAcao();
    }

    protected abstract function getViewName();
    protected abstract function posfixoTituloFormulario();
    //protected abstract function getInstanceModel();

    protected function getCurrentPageLista() {
        return request()->get('currentPage', 1);
    }

    private function loadCodigoAcao() {
        switch (true) {
            case $this->existsMethodRoute('create'):
            case $this->existsMethodRoute('store'):
                $this->acao = self::FORM_INCLUIR;
            break;
            case $this->existsMethodRoute('edit'):
            case $this->existsMethodRoute('update'):
                $this->acao = self::FORM_ALTERAR;
            break;
            case $this->existsMethodRoute('show'):
            case $this->existsMethodRoute('destroy'):
                $this->acao = self::FORM_EXCLUIR;
            break;
        }
    }

    protected final function createNameForm() {
        switch ($this->acao)  {
            case self::FORM_INCLUIR;
                return "Incluir {$this->posfixoTituloFormulario()}";
            break;
            case self::FORM_ALTERAR;
                return "Alterar {$this->posfixoTituloFormulario()}";
            break;
            case self::FORM_EXCLUIR;
                return "Excluir {$this->posfixoTituloFormulario()}";
            break;
        }
    }

    protected final function existsMethodRoute(string $sNome) {
        $sNomeRota = request()->route()->getAction('as');
        return (strstr($sNomeRota, $sNome) !== false);
    }

    protected function loadViewManutencao($model, ...$params) {
        $data                = isset($params[0]) ? $params[0]: [];
        $data['model']       = $model;
        $data['currentPage'] = $this->getCurrentPageLista();
        $data['tipoForm']    = $this->acao;
        $data['nomeFormulario'] = $this->createNameForm();
        $data['readonly']       = $this->acao === self::FORM_INCLUIR;
        $sNome                  = "{$this->getViewName()}-manutencao";
        return view($sNome, $data);
    }

    protected function loadViewConsulta($models, ...$params) {
        $data                = isset($params[0]) ? $params[0]: [];
        $data['models']      = $models;
        $data['currentPage'] = $models->currentPage();
        $data['success']     = session('success');
        $sNome               = "{$this->getViewName()}-consulta";
        return view($sNome, $data);
    }

}
