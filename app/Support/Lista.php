<?php

namespace App\Support;

/**
 * Description of Lista
 *
 * @author Jessé Rafael das Neves
 */
class Lista {

    private $codigo;
    private $nome;

    public function __construct(int $codigo, string $nome) {
        $this->codigo = $codigo;
        $this->nome   = $nome;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getNome() {
        return $this->nome;
    }

}
