<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Pessoa;

class PessoaController extends ControllerBase {

    /** @var Pessoa */
    private $Pessoa;

    public function __construct() {
        $this->middleware('auth');
        $this->Pessoa = new Pessoa();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        /* @var $pessoas Pessoa */
        $pessoas     = $this->Pessoa->orderBy('id')->paginate(10);
        $currentPage = $pessoas->currentPage();
        $success     = session('success');

        return view('pessoa-consulta', compact('pessoas', 'currentPage', 'success'));
    }

    private function createViewManutencao(Pessoa $pessoa, int $tipoForm, string $nomeFormulario, bool $bReadonly = false, $currentPage = 1) {
        $readonly    = $bReadonly ? 'readonly' : '';
        $aTipoPessoa = Pessoa::getListaTipo();
        return view('pessoa-manutencao', compact('pessoa', 'tipoForm', 'readonly', 'nomeFormulario', 'currentPage', 'aTipoPessoa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $pessoa      = $this->Pessoa;
        $nomeForm    = "Incluir Pessoa";
        $currentPage = request()->get('currentPage', 1);

        $pessoa->setAttribute('id'  , old('id'));
        $pessoa->setAttribute('nome', old('nome'));

        return $this->createViewManutencao($pessoa, self::FORM_INCLUIR, $nomeForm, false, $currentPage);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $pessoa       = $this->Pessoa->find($id);
        $nomeForm    = "Excluir Pessoa [Id: $id]";
        $currentPage = request()->get('currentPage', 1);

        return $this->createViewManutencao($pessoa, self::FORM_EXCLUIR, $nomeForm, true, $currentPage);
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
        $nomeForm    = "Alterar Pessoa [Id: $id]";
        $currentPage = request()->get('currentPage', 1);

        if(count(old()) > 0) {
            $pessoa->setAttribute('id'  , old('id'));
            $pessoa->setAttribute('nome', old('nome'));
        }

        return $this->createViewManutencao($pessoa, self::FORM_ALTERAR, $nomeForm, false, $currentPage);
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
