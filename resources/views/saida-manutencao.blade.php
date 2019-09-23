@extends('layouts.app')

@section('content')

    @include('form-app.open-default', ['prefixRoute' => 'saidas'])

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Código:</label>
        <div class="col-sm-10">
            <input type="number" name="id" readonly="true" disabled="true" class="form-control  form-control-sm" value="{{$model->id}}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Data:</label>
        <div class="col-sm-10">
            <input type="date" name="data" {{$readonly}} class="form-control form-control-sm" value="{{$model->data}}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Hora:</label>
        <div class="col-sm-10">
            <input type="time" name="hora" {{$readonly}} class="form-control form-control-sm" value="{{$model->hora}}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Pessoa:</label>
        <div class="col-sm-10">
            <select class="form-control form-control-sm" name="idpessoa" {{!is_null($readonly) ? 'disabled' : ''}} >
                <option>Selecione...</option>
                @foreach($aPessoas as $oPessoa)
                    <option value="{{$oPessoa->getCodigo()}}" {{$oPessoa->getAtributosAsString()}}>{{$oPessoa->getNome()}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Observação:</label>
        <div class="col-sm-10">
            <textarea name="observacao" rows="3" {{$readonly}} class="form-control form-control-sm">{{$model->observacao}}</textarea>
        </div>
    </div>

    @include('form-app.button-submit-default', ['prefixRoute' => 'saidas'])
    @include('form-app.close-default')

@endsection