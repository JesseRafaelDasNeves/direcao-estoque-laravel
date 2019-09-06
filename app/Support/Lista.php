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
    private $atributos;

    public function __construct(string $codigo, string $nome, Array $atributos = []) {
        $this->codigo    = $codigo;
        $this->nome      = $nome;
        $this->atributos = $atributos;
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

    public function setAtributos(Array $atributos) {
        $this->atributos = $atributos;
    }

    public function getAtributos() {
        return $this->atributos;
    }

    public function addAtributo(string $nome, string $valor = null) {
        $this->atributos[$nome] = $valor;
    }

    public function temAtributo(string $nome) {
        return isset($this->atributos[$nome]);
    }

    public function valorAtributo(string $nome) {
        return isset($this->atributos[$nome]) ? $this->atributos[$nome] : null;
    }

    public function getAtributosAsString() {
        $retorno = ' ';
        foreach ($this->getAtributos() as $nome => $valor) {
            $retorno .= $nome;
            if(!is_null($valor)) {
                $retorno .= '"' . $valor . '"';
            }
            $retorno .= ' ';
        }
        return $retorno;
    }

    public static function seleciona(Array $aLista, string $codigo = null) {
        foreach ($aLista as /* @var $oLista Lista */ $oLista) {
            if($oLista->getCodigo() == $codigo) {
                $oLista->addAtributo('selected');
            }
        }
    }

    /**
     * @param int $codigo
     * @return Lista
     */
    public static function getItem(Array $aLista, string $codigo) {
        $oRetorno = null;
        foreach ($aLista as /* @var $oLista Lista */ $oLista) {
            if($oLista->getCodigo() == $codigo) {
                $oRetorno = $oLista;
                break;
            }
        }
        return $oRetorno;
    }

}
