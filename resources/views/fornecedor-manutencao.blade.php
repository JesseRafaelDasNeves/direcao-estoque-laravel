@extends('layouts.app')

@section('content')

    @include('form-app.open-default', ['prefixRoute' => 'fornecedores'])

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Código:</label>
        <div class="col-sm-10">
            <input type="number" name="id" readonly="true" disabled="true" class="form-control  form-control-sm" value="{{$model->id}}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Tipo:</label>
        <div class="col-sm-10">
            <select class="form-control form-control-sm" name="tipo" {{!is_null($readonly) ? 'disabled' : ''}} >
                <option>Selecione...</option>
                @foreach($aTipoEmpresa as $oOption)
                    <option value="{{$oOption->getCodigo()}}" {{$oOption->getAtributosAsString()}} > {{$oOption->getNome()}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Inscrição Estadual:</label>
        <div class="col-sm-10">
            <input type="text" name="inscricaoestadual" {{$readonly}} class="form-control form-control-sm" value="{{$model->inscricaoestadual}}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Pessoa:</label>
        <div class="col-sm-10">
            <!--<div class="col">
                <input type="number" readonly="" class="form-control form-control-sm" value="{{$model->getPessoa()->id}}">
            </div>-->
            <!--<input type="search" name="idpessoa" {{$readonly}} class="form-control form-control-sm" value="{{$model->idpessoa}}">-->
            <!--<select class="form-control form-control-sm" name="idpessoa" {{!is_null($readonly) ? 'disabled' : ''}} > -->
            <!--<div class="col">
                <input
                    class="form-control form-control-sm"
                    name="nomePessoa"
                    type="search"
                    list="lista_pessoas"
                    onchange="onChangeNomePessoa(this);"
                    autocomplete="false"
                    placeholder="Digite o nome"
                    value="{{$model->getPessoa()->nome}}"
                >
                <datalist id="lista_pessoas" onselect="alert('teste')">
                    @foreach($aPessoas as $oPessoa)
                    <option onselect="alert('teste option')" value="{{$oPessoa->getNome()}}"></option>
                    @endforeach
                </datalist>
            </div>-->
            <select class="form-control form-control-sm" name="idpessoa" {{!is_null($readonly) ? 'disabled' : ''}} >
                <option>Selecione...</option>
                @foreach($aPessoas as $oPessoa)
                <option value="{{$oPessoa->getCodigo()}}" {{$oPessoa->getAtributosAsString()}}>{{$oPessoa->getNome()}}</option>
                @endforeach
            </select>
        </div>
    </div>

    @include('form-app.button-submit-default', ['prefixRoute' => 'fornecedores'])
    @include('form-app.close-default')

@endsection