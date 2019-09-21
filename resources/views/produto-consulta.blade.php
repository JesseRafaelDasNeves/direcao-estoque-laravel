@extends('layouts.app')

@section('content')

@include('layouts.alert-success')

<div class="btn-group-sm" >
    <a href="{{route('produtos.create', ['currentPage' => $currentPage])}}" class="btn btn-primary">Incluir</a>
</div>

<div class="table-responsive-sm">
    <table class="table table-sm table-striped">
        <caption>Lista de Produtos</caption>
        <thead>
            <tr>
                <th scope="col" style="width: 100px;">Código</th>
                <th scope="col">Nome</th>
                <th scope="col" style="width: 100px;">Unidade</th>
                <th scope="col" style="width: 100px;">Categoria</th>
                <th scope="col" style="width: 100px; text-align: right">Qtde. Estoque</th>
                <th scope="col" style="width: 50px;">Ações</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($models))
                @foreach($models as $produto)
                <tr>
                    <td>{{$produto->id}}</td>
                    <td>{{$produto->nome}}</td>
                    <td>{{$produto->getDestricaoUnidade()}}</td>
                    <td>{{$produto->getDestricaoCategoria()}}</td>
                    <td style="text-align: right">{{$produto->getQuantidadeEstoque()}}</td>
                    <td style="text-align: right;">
                        @include('grid-app.row-container-acao', ['id' => $produto->id, 'prefixRoute' => 'produtos'])
                    </td>
                </tr>
                @endforeach
            @endif

        </tbody>
    </table>
</div>

{{$models->links()}}

@endsection