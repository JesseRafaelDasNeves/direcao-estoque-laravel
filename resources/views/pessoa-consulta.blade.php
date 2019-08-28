@extends('layouts.app')

@section('content')

@if(isset($success))
    <div class="alert alert-success alert-dismissible fade show" role="alert" >
        {{$success}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="btn-group-sm" >
    <a href="{{route('pessoas.create', ['currentPage' => $currentPage])}}" class="btn btn-primary">Incluir</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th style="width: 200px;" scope="col">Código</th>
            <th scope="col">Nome</th>
            <th scope="col">CPF/CNPJ</th>
            <th style="width: 150px" scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($pessoas))
            @foreach($pessoas as $pessoa)
            <tr>
                <td>{{$pessoa->id}}</td>
                <td>{{$pessoa->nome}}</td>
                <td>{{$pessoa->cpfcnpj}}</td>
                <td>
                    <div class="btn-group-sm">
                        <a href="{{route('pessoas.edit', ['id' => $pessoa->id, 'currentPage' => $currentPage])}}" class="btn btn-secondary">Alterar</a>
                        <a href="{{route('pessoas.show', ['id' => $pessoa->id, 'currentPage' => $currentPage])}}" class="btn btn-danger">Excluir</a>
                    </div>
                </td>
            </tr>
            @endforeach
        @endif

    </tbody>
</table>

{{$pessoas->links()}}

@endsection