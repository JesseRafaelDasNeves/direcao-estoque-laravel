@extends('layouts.app')

@section('content')

    @include('form-app.open-default', ['prefixRoute' => 'entradas'])

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
        <label class="col-sm-2 col-form-label">Número Nota:</label>
        <div class="col-sm-10">
            <input type="number" name="numero_nota" {{$readonly}} class="form-control form-control-sm" value="{{$model->numero_nota}}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Observação:</label>
        <div class="col-sm-10">
            <textarea name="observacao" rows="3" {{$readonly}} class="form-control form-control-sm">{{$model->observacao}}</textarea>
        </div>
    </div>

    @include('form-app.button-submit-default', ['prefixRoute' => 'entradas'])
    @include('form-app.close-default')

@endsection