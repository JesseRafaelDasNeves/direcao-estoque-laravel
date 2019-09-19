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

    const FORM_INCLUIR   = 10,
          FORM_ALTERAR   = 11,
          FORM_EXCLUIR   = 12,
          FORM_CONSULTAR = 13;

    public function __construct() {
        $this->Model = $this->getInstanceModel();
    }

    protected abstract function getName();

    protected abstract function posfixoTitulo();

    protected abstract function prefixoRoute();

    protected function posfixoTituloConsulta() {}

    protected abstract function getInstanceModel();

    protected function getParamsExtraViewManutencao($oModel) : array {
        return [];
    }

    protected function getParamsExtraViewConsulta() : array {
        return [];
    }

    protected function getParamsRoute($oModel) : array {
        return [];
    }

    protected function beforeCreateView() : void {}

    private function createParamsRoute($oModel) : array {
        $currentPage = request()->get('currentPage', 1);
        return array_merge($this->getParamsRoute($oModel), ['currentPage' => $currentPage]);
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
            case $this->existsMethodRoute('index'):
                $this->codigoAcao = self::FORM_CONSULTAR;
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
            case self::FORM_CONSULTAR;
                return "Consultar {$this->posfixoTituloConsulta()}";
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
        $data                   = isset($params[0]) ? $params[0]: [];
        $data['models']         = $models;
        $data['currentPage']    = $models->currentPage();
        $data['success']        = session('success');
        $data['nomeFormulario'] = $this->createNameForm();
        $sNome                  = "{$this->getName()}-consulta";
        return view($sNome, $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        /* @var $models Model */
        $models = $this->Model->orderBy('id')->paginate(10);
        return $this->loadViewConsulta($models, $this->getParamsExtraViewConsulta());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->Model->setRawAttributes(old());
        $this->beforeCreateView();
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
        $bModelInsert = $this->executeCreate($request);

        if($bModelInsert) {
            $currentPage  = request()->get('currentPage', 1);
            $success      = "{$this->posfixoTitulo()} incluído(a) com sucesso.";
            $aParamsRoute = $this->createParamsRoute($bModelInsert);
            return redirect()->route("{$this->prefixoRoute()}.index", $aParamsRoute)->with('success', $success);
        }

        return redirect()->route("{$this->prefixoRoute()}.create");
    }

    protected function executeCreate(Request $request) {
        return $this->Model->create($request->all());
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
        $oModelUpdate = $model->update($request->all());

        if($oModelUpdate) {
            $currentPage = $request->get('currentPage', 1);
            $success     = "{$this->posfixoTitulo()} alterado(a) com sucesso.";
            return redirect()->route("{$this->prefixoRoute()}.index", $this->createParamsRoute($model))->with('success', $success);
        }

        return redirect()->route("{$this->prefixoRoute()}.update");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $model    = $this->Model->find($id);
        $bExcluiu = $this->Model->destroy($id);

        if($bExcluiu) {
            $currentPage = request()->get('currentPage', 1);
            $success     = "{$this->posfixoTitulo()} excluído(a) com sucesso.";
            $aParamsRoute = $this->createParamsRoute($model);
            return redirect()->route("{$this->prefixoRoute()}.index", $aParamsRoute)->with('success', $success);
        }

        return redirect()->route("{$this->prefixoRoute()}.destroy");
    }

}
