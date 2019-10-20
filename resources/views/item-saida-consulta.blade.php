@extends('layouts.app')

@section('content')

@include('layouts.alert-success')

@if(isset($nomeFormulario))
    <h5><b>{{$nomeFormulario}}</b></h5>
@endif

<div class="btn-group-sm" >
    <a href="{{route('saidas.index', ['currentPage' => $currentPage])}}" class="btn btn-primary">Voltar</a>

    @if($saida->situacao == App\Model\Saida::SITUACAO_EM_ELABORACAO)
        <a href="{{route('itemSaida.create', ['idsaida' => $saida->id, 'currentPage' => $currentPage])}}" class="btn btn-primary">Incluir</a>
    @endif
</div>

<div class="table-responsive-sm">
    <table class="table table-sm table-striped">
        <caption>Lista de Itens da Saída {{isset($saida) ? $saida->id : ''}}</caption>
        <thead>
            <tr>
                <th scope="col" style="width: 100px;">Item</th>
                <th scope="col">Nome</th>
                <th scope="col" style="width: 100px;">Quantidade</th>
                <th scope="col" style="width: 100px;">Vlr. Unitário</th>
                <th scope="col" style="width: 100px; text-align: right">Vlt. Total</th>

                @if($saida->situacao == App\Model\Saida::SITUACAO_EM_ELABORACAO)
                    <th scope="col" style="width: 50px;">Ações</th>
                @endif()
            </tr>
        </thead>
        <tbody>
            @if(isset($models))
                @foreach($models as $itemSaida)
                <tr>
                    <td>{{$itemSaida->id}}</td>
                    <td>{{$itemSaida->produto->nome}}</td>
                    <td>{{$itemSaida->quantidade}}</td>
                    <td>{{$itemSaida->valorunitario}}</td>
                    <td style="text-align: right">{{$itemSaida->valortotal}}</td>
                    @if($saida->situacao == App\Model\Saida::SITUACAO_EM_ELABORACAO)
                        <td style="text-align: right;">
                            <div class="btn-group btn-group-vertical btn-group-sm" role="group">
                                <button id="btnGroupAcoes" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupAcoes" style="padding: 0px; min-width:60px;">
                                    <a class="btn btn-sm btn-secondary"
                                       href="{{route('itemSaida.edit', ['idsaida' => $itemSaida->idsaida, 'id' => $itemSaida->id, 'currentPage' => $currentPage])}}"
                                    >Alterar
                                    </a>
                                    <a class="btn btn-sm btn-danger"
                                       href="{{route('itemSaida.show', ['idsaida' => $itemSaida->idsaida, 'id' => $itemSaida->id, 'currentPage' => $currentPage])}}"
                                       >Excluir
                                    </a>
                                </div>
                            </div>
                        </td>
                    @endif
                </tr>
                @endforeach
            @endif

        </tbody>
    </table>
</div>

{{$models->links()}}

@endsection