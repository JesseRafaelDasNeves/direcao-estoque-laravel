<div class="btn-group-sm">

    @switch($tipoForm)
        @case(12)
            <button type="submit"  class="btn btn-danger">Confirmar Exclusão</button>
        @break
        @default
            <button type="submit" class="btn btn-primary">Confirmar</button>
    @endswitch

    <a class="btn btn-primary" href="{{route("$prefixRoute.index")}}" role="button">Cancelar</a>
</div>