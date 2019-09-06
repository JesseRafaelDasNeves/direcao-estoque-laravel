<div class="btn-group btn-group-vertical btn-group-sm" role="group">
    <button id="btnGroupAcoes" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupAcoes" style="padding: 0px; min-width:60px;">
        <a class="btn btn-sm btn-secondary"
           href="{{route("$prefixRoute.edit", ['id' => $id, 'currentPage' => $currentPage])}}"
        >Alterar
        </a>
        <a class="btn btn-sm btn-danger"
           href="{{route("$prefixRoute.show", ['id' => $id, 'currentPage' => $currentPage])}}"
           >Excluir
        </a>
    </div>
</div>