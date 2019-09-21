@extends('layouts.app')

@section('content')

@include('layouts.alert-success')

@if(isset($nomeFormulario))
    <h5><b>{{$nomeFormulario}}</b></h5>
@endif

<div class="btn-group-sm" >
    <a href="{{route('entradas.index', ['currentPage' => $currentPage])}}" class="btn btn-primary">Voltar</a>

    @if($entrada->situacao == App\Model\Entrada::SITUACAO_EM_ELABORACAO)
        <a href="{{route('itemEntrada.create', ['identrada' => $entrada->id, 'currentPage' => $currentPage])}}" class="btn btn-primary">Incluir</a>
    @endif
</div>

<div class="table-responsive-sm">
    <table class="table table-sm table-striped">
        <caption>Lista de Itens da Entrada {{isset($entrada) ? $entrada->id : ''}}</caption>
        <thead>
            <tr>
                <th scope="col" style="width: 100px;">Item</th>
                <th scope="col">Nome</th>
                <th scope="col" style="width: 100px;">Quantidade</th>
                <th scope="col" style="width: 100px;">Vlr. Unitário</th>
                <th scope="col" style="width: 100px; text-align: right">Vlt. Total</th>

                @if($entrada->situacao == App\Model\Entrada::SITUACAO_EM_ELABORACAO)
                    <th scope="col" style="width: 50px;">Ações</th>
                @endif()
            </tr>
        </thead>
        <tbody>
            @if(isset($models))
                @foreach($models as $itemEntrada)
                <tr>
                    <td>{{$itemEntrada->id}}</td>
                    <td>{{$itemEntrada->produto->nome}}</td>
                    <td>{{$itemEntrada->quantidade}}</td>
                    <td>{{$itemEntrada->valorunitario}}</td>
                    <td style="text-align: right">{{$itemEntrada->valortotal}}</td>
                    @if($entrada->situacao == App\Model\Entrada::SITUACAO_EM_ELABORACAO)
                        <td style="text-align: right;">
                            <div class="btn-group btn-group-vertical btn-group-sm" role="group">
                                <button id="btnGroupAcoes" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupAcoes" style="padding: 0px; min-width:60px;">
                                    <a class="btn btn-sm btn-secondary"
                                       href="{{route("itemEntrada.edit", ['identrada' => $itemEntrada->identrada, 'id' => $itemEntrada->id, 'currentPage' => $currentPage])}}"
                                    >Alterar
                                    </a>
                                    <a class="btn btn-sm btn-danger"
                                       href="{{route("itemEntrada.show", ['identrada' => $itemEntrada->identrada, 'id' => $itemEntrada->id, 'currentPage' => $currentPage])}}"
                                       >Excluir
                                    </a>
                                </div>
                            </div>
                        </td>
                    @endif()
                </tr>
                @endforeach
            @endif

        </tbody>
    </table>
</div>

{{$models->links()}}

@endsection