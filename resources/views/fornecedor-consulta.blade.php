@extends('layouts.app')

@section('content')

@include('layouts.alert-success')

<div class="btn-group-sm" >
    <a href="{{route('fornecedores.create', ['currentPage' => $currentPage])}}" class="btn btn-primary">Incluir</a>
</div>

<table class="table table-sm table-striped">
    <caption>Lista de Fornecedores</caption>
    <thead>
        <tr>
            <th scope="col" style="width: 200px;">Código</th>
            <th scope="col">Tipo Empresa</th>
            <th scope="col">Nome</th>
            <th scope="col" style="width: 150px">Ações</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($models))
            @foreach($models as $fornecedor)
            <tr>
                <td>{{$fornecedor->id}}</td>
                <td>{{$fornecedor->getDestricaoTipo()}}</td>
                <td>{{$fornecedor->getPessoa()->nome}}</td>
                <td>
                    <div class="btn-group-sm">
                        <a href="{{route('fornecedores.edit', ['id' => $fornecedor->id, 'currentPage' => $currentPage])}}" class="btn btn-secondary">Alterar</a>
                        <a href="{{route('fornecedores.show', ['id' => $fornecedor->id, 'currentPage' => $currentPage])}}" class="btn btn-danger">Excluir</a>
                    </div>
                </td>
            </tr>
            @endforeach
        @endif

    </tbody>
</table>

{{$models->links()}}

@endsection