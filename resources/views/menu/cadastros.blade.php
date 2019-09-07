<li class="nav-item dropdown">
    <a id="navbarCadastro" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Cadastros<span class="caret"></span>
    </a>

    <div class="dropdown-menu" aria-labelledby="navbarCadastro">
        <a class="dropdown-item" href="{{ route('pessoas.index') }}">
            {{ __('Pessoa') }}
        </a>

        <a class="dropdown-item" href="{{ route('fornecedores.index') }}">
            {{ __('Fornecedor') }}
        </a>
        <a class="dropdown-item" href="{{ route('produtos.index') }}">
            {{ __('Produto') }}
        </a>
    </div>
</li>