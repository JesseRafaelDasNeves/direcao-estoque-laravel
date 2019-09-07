@extends('layouts.app')

@section('content')

@include('layouts.alert-success')

<div class="btn-group-sm" >
    <a href="{{route('entradas.create', ['currentPage' => $currentPage])}}" class="btn btn-primary">Incluir</a>
</div>

<table class="table table-sm table-striped">
    <caption>Lista de Entradas</caption>
    <thead>
        <tr>
            <th scope="col" style="width: 100px;">Código</th>
            <th scope="col" style="width: 200px;">Data</th>
            <th scope="col">Número Nota Fiscal</th>
            <th scope="col" style="width: 100px;text-align: right">Valor Total</th>
            <th scope="col" style="width: 50px;">Ações</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($models))
            @foreach($models as $entrada)
            <tr>
                <td>{{$entrada->id}}</td>
                <td>{{$entrada->data_hora}}</td>
                <td>{{$entrada->numero_nota}}</td>
                <td style="text-align: right;">{{$entrada->valor_total}}</td>
                <td style="text-align: right;">
                    @include('grid-app.row-container-acao', ['id' => $entrada->id, 'prefixRoute' => 'entradas'])
                </td>
            </tr>
            @endforeach
        @endif

    </tbody>
</table>

{{$models->links()}}

@endsection