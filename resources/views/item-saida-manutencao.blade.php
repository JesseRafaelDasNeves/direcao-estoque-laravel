@extends('layouts.app')

@section('content')

<script>

    function preenchido(valor) {
        return (valor != '') && (valor != null);
    }

    function calculaValorTotalItemSaida() {
        let oCampoValorTotal = $('#valortotal'),
            oCampoValorUnit  = $('#valorunitario'),
            oCampoQuantidade = $('#quantidade');

        if(preenchido(oCampoQuantidade.val()) && preenchido(oCampoValorUnit.val())) {
            fQuantidade = parseFloat(oCampoQuantidade.val());
            fVlrUnit    = parseFloat(oCampoValorUnit.val());
            oCampoValorTotal.val(fQuantidade * fVlrUnit);
        }
    }

    function onChangeCampoQuantidadeItemSaida() {
        calculaValorTotalItemSaida();
    }

    function onChangeCampoValorUnitarioItemSaida() {
        calculaValorTotalItemSaida();
    }

    function onChangeCampoProdutoItemSaida(iTipoForm) {
        if(iTipoForm != 10) {
            return;
        }

        let idProduto = parseFloat($('#idproduto').val());

        if(idProduto > 0) {
            $.get('qtdeEstoqueProduto/' + idProduto, function(iRetornoQtdeEstoque) {
                $('#quantidadeEstoque').val(iRetornoQtdeEstoque);
            });
            return;
        }

        $('#quantidadeEstoque').val(null);
    }

</script>

    @include('form-app.open-with-params', ['prefixRoute' => 'itemSaida', 'aParams' => ['idsaida' => $model->idsaida, 'id' => $model->id, 'currentPage' => $currentPage]])

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Item:</label>
        <div class="col-sm-10">
            <input type="number" name="id" readonly="true" disabled="true" class="form-control  form-control-sm" value="{{$model->id}}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Cód. Saída:</label>
        <div class="col-sm-10">
            <input type="number" name="idsaida" readonly="true" class="form-control  form-control-sm" value="{{$model->idsaida}}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Produto:</label>
        <div class="col-sm-10">
            <select class="form-control form-control-sm" id="idproduto" name="idproduto" {{($tipoForm != 10) ? 'readonly' : ''}}
                    onchange="onChangeCampoProdutoItemSaida({{$tipoForm}})">
                <option>Selecione...</option>
                @foreach($aProdutos as $oProduto)
                    <option value="{{$oProduto->getCodigo()}}" {{$oProduto->getAtributosAsString()}}>{{$oProduto->getNome()}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Qtde. Atual Estoque:</label>
        <div class="col-sm-10">
            <input type="number" id="quantidadeEstoque"name="quantidadeEstoque" readonly="true" class="form-control form-control-sm" value="{{$model->quantidadeEstoque}}" >
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Quantidade:</label>
        <div class="col-sm-10">
            <input type="number" id="quantidade" name="quantidade" {{$readonly}} class="form-control form-control-sm" value="{{$model->quantidade}}"
                   onchange="onChangeCampoQuantidadeItemSaida()">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Valor Unitário:</label>
        <div class="col-sm-10">
            <input type="number" id="valorunitario" name="valorunitario" {{$readonly}} class="form-control form-control-sm" value="{{$model->valorunitario}}"
                   onchange="onChangeCampoValorUnitarioItemSaida()">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Valor Total:</label>
        <div class="col-sm-10">
            <input type="number" id="valortotal" name="valortotal" readonly class="form-control form-control-sm" value="{{$model->valortotal}}">
        </div>
    </div>

    @include('form-app.button-submit-default', ['prefixRoute' => 'itemSaida', 'params' => ['idsaida' => $model->idsaida]])
    @include('form-app.close-default')

@endsection