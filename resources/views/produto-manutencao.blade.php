@extends('layouts.app')

@section('content')

    @include('form-app.open-default', ['prefixRoute' => 'produtos'])

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Código:</label>
        <div class="col-sm-10">
            <input type="number" name="id" readonly="true" disabled="true" class="form-control  form-control-sm" value="{{$model->id}}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Nome:</label>
        <div class="col-sm-10">
            <input type="text" name="nome" {{$readonly}} class="form-control form-control-sm" value="{{$model->nome}}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Categoria:</label>
        <div class="col-sm-10">
            <select class="form-control form-control-sm" name="categoria" {{!is_null($readonly) ? 'disabled' : ''}} >
                <option>Selecione...</option>
                @foreach($aCategoria as $oOption)
                    <option value="{{$oOption->getCodigo()}}" {{$oOption->getAtributosAsString()}} > {{$oOption->getNome()}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Unidade:</label>
        <div class="col-sm-10">
            <select class="form-control form-control-sm" name="unidade" {{!is_null($readonly) ? 'disabled' : ''}} >
                <option>Selecione...</option>
                @foreach($aUnidade as $oOption)
                    <option value="{{$oOption->getCodigo()}}" {{$oOption->getAtributosAsString()}} > {{$oOption->getNome()}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Descrição:</label>
        <div class="col-sm-10">
            <textarea name="descricao" rows="3" {{$readonly}} class="form-control form-control-sm">{{$model->descricao}}</textarea>
        </div>
    </div>

    @include('form-app.button-submit-default', ['prefixRoute' => 'produtos'])
    @include('form-app.close-default')

@endsection