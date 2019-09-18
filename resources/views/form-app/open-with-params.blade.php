@if(isset($nomeFormulario))
    <h5><b>{{$nomeFormulario}}</b></h5>
@endif

@include('layouts.alert-errors')

@switch($tipoForm)
    @case(10)
        <form method="post" action="{{route("$prefixRoute.store", $aParams)}}">
    @break
    @case(11)
        <form method="post" action="{{route("$prefixRoute.update", $aParams)}}">
        @method('PUT')
    @break
    @case(12)
        <form method="post" action="{{route("$prefixRoute.destroy", $aParams)}}">
        @method('DELETE')
    @break
@endswitch

@csrf