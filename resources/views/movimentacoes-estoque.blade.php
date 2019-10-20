@extends('layouts.app')

@section('content')

<h3>{{'Movimentações do Estoque'}}</h3>

<div class="table-responsive table-responsive-sm">
    <table class="table table-sm table-striped">
        <thead style="background-color: #292d31; color: white">
            <tr>
                <th scope="col" style="width: 80px;">Estoque</th>
                <th scope="col" colspan="4" style="width: 100px;">Produto</th>
            </tr>
        </thead>
        @foreach ($estoques as $estoque)
        <tbody style="background-color: black; color: white;">
            <tr>
                <td style="background-color: #2e2d2d; color: white;">
                    {{$estoque->id}}
                </td>
                <td colspan="4" style="background-color: #2e2d2d; color: white;">
                    {{$estoque->produto->nome}}
                </td>
            </tr>
        </tbody>

        <thead style="background-color: #777; color: white">
            <tr>
                <th scope="col" >Tipo</th>
                <th scope="col" >Data</th>
                <th scope="col" style="text-align: right;" >Vlr. Unitário</th>
                <th scope="col" style="text-align: right;" >Vlr. Total</th>
                <th scope="col" style="text-align: right;" >Quantidade</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movimentacoes[$estoque->id] as $movimentacao)
            <tr>
                <td>{{$movimentacao->tipo}}</td>
                <td>{{date_format(date_create($movimentacao->data), 'd/m/Y')}}</td>
                <td style="text-align: right;" >{{number_format($movimentacao->valorunitario   , 2, ',', '.')}}</td>
                <td style="text-align: right;" >{{number_format($movimentacao->valortotal      , 2, ',', '.')}}</td>
                <td style="text-align: right;" >{{number_format($movimentacao->qtde_movimentada, 2, ',', '.')}}</td>
            </tr>
            @endforeach

            <tr>
                <td style="text-align: right;" colspan="4"><b>Qtde. Total Estoque:</b></td>
                <td style="text-align: right;" ><b>{{number_format($estoque->quantidade, 2, ',', '.')}}</b></td>
            </tr>
        </tbody>
        @endforeach
    </table>
</div>

@endsection