<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Pessoa;

class PessoaController extends ControllerBase {

    /** @var Pessoa */
    private $Pessoa;

    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
        $this->Pessoa = new Pessoa();
    }

    protected function getViewName() {
        return 'pessoa';
    }

    protected function posfixoTituloFormulario() {
        return 'Pessoa';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        /* @var $models Pessoa */
        $models      = $this->Pessoa->orderBy('id')->paginate(10);
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
        $this->Pessoa->setAttribute('id'  , old('id'));
        $this->Pessoa->setAttribute('nome', old('nome'));
        return $this->loadViewManutencao($this->Pessoa, ['aTipoPessoa' => Pessoa::getListaTipo()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, $this->Pessoa->getRules(), $this->Pessoa->getMessageValidate());
        $bInseriu = $this->Pessoa->create($request->all());

        if($bInseriu) {
            $currentPage = request()->get('currentPage', 1);
            $success     = 'Pessoa incluída com sucesso.';
            return redirect()->route('pessoas.index', ['page' => $currentPage])->with('success', $success);
        }

        return redirect()->route('pessoas.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        /* @var $pessoa Pessoa */
        $pessoa       = $this->Pessoa->find($id);

        if(count(old()) > 0) {
            $pessoa->setAttribute('id'  , old('id'));
            $pessoa->setAttribute('nome', old('nome'));
        }

        return $this->loadViewManutencao($pessoa, ['aTipoPessoa' => Pessoa::getListaTipo()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        /* @var $pessoa Pessoa */
        $pessoa    = $this->Pessoa->find($id);
        $this->validate($request, $pessoa->getRules(), $pessoa->getMessageValidate());
        $bAlterou = $pessoa->update($request->all());

        if($bAlterou) {
            $currentPage = $request->get('currentPage', 1);
            $success     = 'Pessoa alterada com sucesso.';
            return redirect()->route('pessoas.index', ['page' => $currentPage])->with('success', $success);
        }

        return redirect()->route('pessoas.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $pessoa = $this->Pessoa->find($id);
        return $this->loadViewManutencao($pessoa, ['aTipoPessoa' => Pessoa::getListaTipo()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $bdelete = $this->Pessoa->destroy($id);

        if($bdelete) {
            $currentPage = request()->get('currentPage', 1);
            $success     = 'Pessoa excluída com sucesso.';
            return redirect()->route('pessoas.index', ['page' => $currentPage])->with('success', $success);
        }

        return redirect()->route('pessoas.destroy');
    }

}
