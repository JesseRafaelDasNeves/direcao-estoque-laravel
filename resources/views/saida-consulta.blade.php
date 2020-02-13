@extends('layouts.app')

@section('content')

@include('layouts.alert-success')
@include('layouts.alert-errors')

<div class="btn-group-sm" >
    <a href="{{route('saidas.create', ['currentPage' => $currentPage])}}" class="btn btn-primary">Incluir</a>
</div>

<div class="table-responsive-sm">
    <table class="table table-sm table-striped">
        <caption>Lista de Saídas</caption>
        <thead>
            <tr>
                <th scope="col" style="width: 80px;">Código</th>
                <th scope="col" style="width: 100px;">Data</th>
                <th scope="col" style="width: 100px;">Hora</th>
                <th scope="col">Pessoa</th>
                <th scope="col" style="width: 150px;">Situação</th>
                <th scope="col" style="width: 100px;text-align: right">Valor Total</th>
                <th scope="col" style="width: 50px;">Ações</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($models))
                @foreach($models as $saida)
                <tr>
                    <td>{{$saida->id}}</td>
                    <td>{{$saida->getDataFomatada()}}</td>
                    <td>{{$saida->hora}}</td>
                    <td>{{$saida->pessoa->nome}}</td>
                    <td>{{$saida->getDestricaoSituacao()}}</td>
                    <td style="text-align: right;">{{$saida->getValorTotal()}}</td>
                    <td style="text-align: right;">
                        @include('grid-app.row-container-acao', [
                            'id' => $saida->id,
                            'prefixRoute' => 'saidas',
                            'rotasExtras' => [
                                route('itemSaida.index', ['idsaida' => $saida->id]) => 'Itens',
                                route('saidas.conclui' , ['id'      => $saida->id]) => 'Concluir'
                            ]
                        ])
                    </td>
                </tr>
                @endforeach
            @endif

        </tbody>
    </table>
</div>
{{$models->links()}}

@endsection