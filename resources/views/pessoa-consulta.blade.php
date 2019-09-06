@extends('layouts.app')

@section('content')

@include('layouts.alert-success')

<div class="btn-group-sm" >
    <a href="{{route('pessoas.create', ['currentPage' => $currentPage])}}" class="btn btn-primary">Incluir</a>
</div>

<div class="table-responsive-sm">
    <table class="table table-sm table-striped">
        <caption>Lista de Pessoas</caption>
        <thead>
            <tr>
                <th scope="col" style="width: 100px;">Código</th>
                <th scope="col">Nome</th>
                <th scope="col">CPF/CNPJ</th>
                <th scope="col" style="width: 150px">Ações</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($models))
                @foreach($models as $pessoa)
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
</div>

{{$models->links()}}

@endsection