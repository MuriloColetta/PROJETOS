<?php
class Treino {
    private $id_treino;
    private $nome_treino;
    private $descricao;
    private $dias;

    public function __construct($id_treino, $nome_treino, $descricao, $dias) {
        $this->id_treino = $id_treino;
        $this->nome_treino = $nome_treino;
        $this->descricao = $descricao;
        $this->dias = $dias;
    }

    public function getNomeTreino() {
        return $this->nome_treino;
    }

    public function setNomeTreino($nome_treino) {
        $this->nome_treino = $nome_treino;
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