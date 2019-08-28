@extends('layouts.app')

@section('content')

    @if(isset($pessoa))
    <h5><b>{{$nomeFormulario}}</b></h5>
    @endif

    @if(isset($errors) && count($errors) > 0)

    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}.</li>
            @endforeach
        </ul>
    </div>

    @endif

    @switch($tipoForm)
        @case(10)
            <form method="post" action="{{route('pessoas.store', ['currentPage' => $currentPage])}}">
        @break
        @case(11)
            <form method="post" action="{{route('pessoas.update', ['id' => $pessoa->id, 'currentPage' => $currentPage])}}">
            @method('PUT')
        @break
        @case(12)
            <form method="post" action="{{route('pessoas.destroy', ['id' => $pessoa->id, 'currentPage' => $currentPage])}}">
            @method('DELETE')
        @break
    @endswitch

    @csrf

    <div class="form-group">
        <label>Código:</label>
        <input type="number" name="id" readonly="true" disabled="true" class="form-control" value="{{$pessoa->id}}">
    </div>

    <div class="form-group">
        <label>Tipo:</label>
        <select class="form-control" name="tipo" {{$readonly == 'readonly' ? 'disabled' : null}} {{$readonly}} class="form-control" >
            <option>Selecione...</option>
            @foreach($aTipoPessoa as $oOption)
                <option
                    value="{{$oOption->getCodigo()}}"
                    {{($pessoa->tipo == $oOption->getCodigo()) ? 'selected' : null}}
                    >{{$oOption->getNome()}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>CPF / CNPJ:</label>
        <input type="text" name="cpfcnpj" {{$readonly}} class="form-control" value="{{$pessoa->cpfcnpj}}">
    </div>

    <div class="form-group">
        <label>Nome:</label>
        <input type="text" name="nome" {{$readonly}} class="form-control" value="{{$pessoa->nome}}">
    </div>

    <div class="btn-group-sm">

        @switch($tipoForm)
            @case(12)
                <button type="submit" class="btn btn-danger">Confirmar Exclusão</button>
            @break
            @default
                <button type="submit" class="btn btn-primary">Confirmar</button>
        @endswitch

        <a class="btn btn-primary" href="{{route('pessoas.index')}}" role="button">Cancelar</a>
    </div>
</form>

@endsection