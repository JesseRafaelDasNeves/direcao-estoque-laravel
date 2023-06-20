@extends('layouts.app')

@section ('title', 'Pessoas')

@section('content')

    @include('form-app.open-default', ['prefixRoute' => 'pessoas'])

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
                @foreach($aTipoPessoa as $oOption)
                    <option value="{{$oOption->getCodigo()}}" {{$oOption->getAtributosAsString()}} > {{$oOption->getNome()}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">CPF / CNPJ:</label>
        <div class="col-sm-10">
            <input type="text" name="cpfcnpj" {{$readonly}} class="form-control form-control-sm" value="{{$model->cpfcnpj}}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Nome:</label>
        <div class="col-sm-10">
            <input type="text" name="nome" {{$readonly}} class="form-control form-control-sm" value="{{$model->nome}}">
        </div>
    </div>

    @include('form-app.button-submit-default', ['prefixRoute' => 'pessoas'])
    @include('form-app.close-default')

@endsection