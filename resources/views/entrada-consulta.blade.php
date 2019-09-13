@extends('layouts.app')

@section('content')

@include('layouts.alert-success')

<div class="btn-group-sm" >
    <a href="{{route('entradas.create', ['currentPage' => $currentPage])}}" class="btn btn-primary">Incluir</a>
</div>

<div class="table-responsive-sm">
    <table class="table table-sm table-striped">
        <caption>Lista de Entradas</caption>
        <thead>
            <tr>
                <th scope="col" style="width: 80px;">Código</th>
                <th scope="col" style="width: 100px;">Data</th>
                <th scope="col" style="width: 100px;">Hora</th>
                <th scope="col" style="width: 100px;">Nº Nota Fiscal</th>
                <th scope="col">Fornecedor</th>
                <th scope="col" style="width: 150px;">Situação</th>
                <th scope="col" style="width: 100px;text-align: right">Valor Total</th>
                <th scope="col" style="width: 50px;">Ações</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($models))
                @foreach($models as $entrada)
                <tr>
                    <td>{{$entrada->id}}</td>
                    <td>{{$entrada->getDataFomatada()}}</td>
                    <td>{{$entrada->hora}}</td>
                    <td>{{$entrada->numero_nota}}</td>
                    <td>{{$entrada->fornecedor->pessoa->nome}}</td>
                    <td>{{$entrada->getDestricaoSituacao()}}</td>
                    <td style="text-align: right;">{{$entrada->valor_total}}</td>
                    <td style="text-align: right;">
                        @include('grid-app.row-container-acao', ['id' => $entrada->id, 'prefixRoute' => 'entradas'])
                    </td>
                </tr>
                @endforeach
            @endif

        </tbody>
    </table>
</div>
{{$models->links()}}

@endsection