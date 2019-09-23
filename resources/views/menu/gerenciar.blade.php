<li class="nav-item dropdown">
    <a id="navbarGerenciar" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Gerenciar<span class="caret"></span>
    </a>

    <div class="dropdown-menu" aria-labelledby="navbarGerenciar">
        <a class="dropdown-item" href="{{ route('entradas.index') }}">
            {{ __('Entrada') }}
        </a>
        <a class="dropdown-item" href="{{ route('saidas.index') }}">
            {{ __('Saída') }}
        </a>
    </div>
</li>