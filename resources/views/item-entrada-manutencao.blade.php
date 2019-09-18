@extends('layouts.app')

@section('content')

<script>

    function preenchido(valor) {
        return (valor != '') && (valor != null);
    }

    function calculaValorTotalItemEntrada() {
        let oCampoValorTotal = $('#valortotal'),
            oCampoValorUnit  = $('#valorunitario'),
            oCampoQuantidade = $('#quantidade');

        if(preenchido(oCampoQuantidade.val()) && preenchido(oCampoValorUnit.val())) {
            fQuantidade = parseFloat(oCampoQuantidade.val());
            fVlrUnit    = parseFloat(oCampoValorUnit.val());
            oCampoValorTotal.val(fQuantidade * fVlrUnit);
        }
    }

    function onChangeCampoQuantidadeItemEntrada() {
        calculaValorTotalItemEntrada();
    }

    function onChangeCampoValorUnitarioItemEntrada() {
        calculaValorTotalItemEntrada();
    }

</script>

    @include('form-app.open-with-params', ['prefixRoute' => 'itemEntrada', 'aParams' => ['identrada' => $model->identrada, 'itemEntrada' => $model->id, 'currentPage' => $currentPage]])

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Item:</label>
        <div class="col-sm-10">
            <input type="number" name="id" readonly="true" disabled="true" class="form-control  form-control-sm" value="{{$model->id}}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Cód. Entrada:</label>
        <div class="col-sm-10">
            <input type="number" name="identrada" readonly="true" class="form-control  form-control-sm" value="{{$model->identrada}}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Produto:</label>
        <div class="col-sm-10">
            <select class="form-control form-control-sm" name="idproduto" {{!is_null($readonly) ? 'disabled' : ''}} >
                <option>Selecione...</option>
                @foreach($aProdutos as $oProduto)
                    <option value="{{$oProduto->getCodigo()}}" {{$oProduto->getAtributosAsString()}}>{{$oProduto->getNome()}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Quantidade:</label>
        <div class="col-sm-10">
            <input type="number" id="quantidade" name="quantidade" {{$readonly}} class="form-control form-control-sm" value="{{$model->quantidade}}"
                   onchange="onChangeCampoQuantidadeItemEntrada()">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Valor Unitário:</label>
        <div class="col-sm-10">
            <input type="number" id="valorunitario" name="valorunitario" {{$readonly}} class="form-control form-control-sm" value="{{$model->valorunitario}}"
                   onchange="onChangeCampoValorUnitarioItemEntrada()">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Valor Total:</label>
        <div class="col-sm-10">
            <input type="number" id="valortotal" name="valortotal" readonly class="form-control form-control-sm" value="{{$model->valortotal}}">
        </div>
    </div>

    @include('form-app.button-submit-default', ['prefixRoute' => 'itemEntrada', 'params' => ['identrada' => $model->identrada]])
    @include('form-app.close-default')

@endsection