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
            <input type="number" name="idpessoa" {{$readonly}} class="form-control form-control-sm" value="{{$model->idpessoa}}">
        </div>
    </div>

    @include('form-app.button-submit-default', ['prefixRoute' => 'fornecedores'])
    @include('form-app.close-default')

@endsection