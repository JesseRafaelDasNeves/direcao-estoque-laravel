<?php

namespace App\Http\Controllers;

use App\Model;
use Illuminate\Http\Request;

/**
 * Description of ControllerBase
 *
 * @author Jessé Rafael das Neves
 */
abstract class ControllerBase extends Controller {

    /** @var Model */
    protected $Model;

    private $codigoAcao;

    const FORM_INCLUIR = 10,
          FORM_ALTERAR = 11,
          FORM_EXCLUIR = 12;

    public function __construct() {
        $this->Model = $this->getInstanceModel();
    }

    protected abstract function getName();

    protected abstract function posfixoTitulo();

    protected abstract function posfixoRoute();

    protected abstract function getInstanceModel();

    protected function getParamsExtraViewManutencao($oModel) : array {
        return [];
    }

    protected function getParamsExtraViewConsulta() : array {
        return [];
    }

    protected final function getCodigoAcao() {
        if (!isset($this->codigoAcao)) {
            $this->loadCodigoAcao();
        }
        return $this->codigoAcao;
    }

    protected function getCurrentPageLista() : int {
        return request()->get('currentPage', 1);
    }

    private function loadCodigoAcao() {
        switch (true) {
            case $this->existsMethodRoute('create'):
            case $this->existsMethodRoute('store'):
                $this->codigoAcao = self::FORM_INCLUIR;
            break;
            case $this->existsMethodRoute('edit'):
            case $this->existsMethodRoute('update'):
                $this->codigoAcao = self::FORM_ALTERAR;
            break;
            case $this->existsMethodRoute('show'):
            case $this->existsMethodRoute('destroy'):
                $this->codigoAcao = self::FORM_EXCLUIR;
            break;
        }
    }

    protected final function createNameForm() {
        switch ($this->getCodigoAcao())  {
            case self::FORM_INCLUIR;
                return "Incluir {$this->posfixoTitulo()}";
            break;
            case self::FORM_ALTERAR;
                return "Alterar {$this->posfixoTitulo()}";
            break;
            case self::FORM_EXCLUIR;
                return "Excluir {$this->posfixoTitulo()}";
            break;
        }
    }

    protected final function existsMethodRoute(string $sNome) : bool {
        $sNomeRota = request()->route()->getAction('as');
        return (strstr($sNomeRota, $sNome) !== false);
    }

    protected function loadViewManutencao($model, ...$params) {
        $data                = isset($params[0]) ? $params[0]: [];
        $data['model']       = $model;
        $data['currentPage'] = $this->getCurrentPageLista();
        $data['tipoForm']    = $this->getCodigoAcao();
        $data['nomeFormulario'] = $this->createNameForm();
        $data['readonly']       = in_array($this->getCodigoAcao(), [self::FORM_EXCLUIR]) ? 'readonly' : null;
        $sNome                  = "{$this->getName()}-manutencao";
        return view($sNome, $data);
    }

    protected function loadViewConsulta($models, ...$params) {
        $data                = isset($params[0]) ? $params[0]: [];
        $data['models']      = $models;
        $data['currentPage'] = $models->currentPage();
        $data['success']     = session('success');
        $sNome               = "{$this->getName()}-consulta";
        return view($sNome, $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        /* @var $models Model */
        $models      = $this->Model->orderBy('id')->paginate(10);
        $currentPage = $models->currentPage();
        $success     = session('success');
        return $this->loadViewConsulta($models);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->Model->setRawAttributes(old());
        return $this->loadViewManutencao($this->Model, $this->getParamsExtraViewManutencao($this->Model));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        /* @var $model Model */
        $model = $this->Model->find($id);
        if(count(old()) > 0) {
            $model->setRawAttributes(old());
        }
        return $this->loadViewManutencao($model, $this->getParamsExtraViewManutencao($model));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $model = $this->Model->find($id);
        return $this->loadViewManutencao($model, $this->getParamsExtraViewManutencao($model));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, $this->Model->getRules(), $this->Model->getMessageValidate());
        $bInseriu = $this->Model->create($request->all());

        if($bInseriu) {
            $currentPage = request()->get('currentPage', 1);
            $success     = "{$this->posfixoTitulo()} incluído(a) com sucesso.";
            return redirect()->route("{$this->posfixoRoute()}.index", ['page' => $currentPage])->with('success', $success);
        }

        return redirect()->route("{$this->posfixoRoute()}.create");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        /* @var $model Model */
        $model    = $this->Model->find($id);
        $this->validate($request, $model->getRules(), $model->getMessageValidate());
        $bAlterou = $model->update($request->all());

        if($bAlterou) {
            $currentPage = $request->get('currentPage', 1);
            $success     = "{$this->posfixoTitulo()} alterado(a) com sucesso.";
            return redirect()->route("{$this->posfixoRoute()}.index", ['page' => $currentPage])->with('success', $success);
        }

        return redirect()->route("{$this->posfixoRoute()}.update");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $bdelete = $this->Model->destroy($id);

        if($bdelete) {
            $currentPage = request()->get('currentPage', 1);
            $success     = "{$this->posfixoTitulo()} excluído(a) com sucesso.";
            return redirect()->route("{$this->posfixoRoute()}.index", ['page' => $currentPage])->with('success', $success);
        }

        return redirect()->route("{$this->posfixoRoute()}.destroy");
    }

}
