@if(isset($nomeFormulario))
    <h5><b>{{$nomeFormulario}}</b></h5>
@endif

@include('layouts.alert-errors')

@switch($tipoForm)
    @case(10)
        <form method="post" action="{{route("$prefixRoute.store", ['currentPage' => $currentPage])}}">
    @break
    @case(11)
        <form method="post" action="{{route("$prefixRoute.update", ['id' => $model->id, 'currentPage' => $currentPage])}}">
        @method('PUT')
    @break
    @case(12)
        <form method="post" action="{{route("$prefixRoute.destroy", ['id' => $model->id, 'currentPage' => $currentPage])}}">
        @method('DELETE')
    @break
@endswitch

@csrf