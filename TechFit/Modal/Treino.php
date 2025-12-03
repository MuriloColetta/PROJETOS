<?php
class Treino {
    private $descricao;
    private $dias;

    public function __construct($descricao, $dias) {
        $this->descricao = $descricao;
        $this->dias = $dias;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getdias() {
        return $this->dias;
    }

    public function setdias($dias) {
        $this->dias = $dias;
    }
}

?>