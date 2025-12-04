<?php
class Plano {
    private $id_plano;
    private $nome_plano;
    private $preco;
    private $descricao;

    public function __construct($id_plano, $nome_plano, $preco, $descricao) {
        $this->id_plano = $id_plano;
        $this->nome_plano = $nome_plano;
        $this->preco = $preco;
        $this->descricao = $descricao;
    }

    public function getNomePlano() {
        return $this->nome_plano;
    }

    public function setNomePlano($nome_plano) {
        $this->nome_plano = $nome_plano;
        return $this;
    }

    public function getPreco() {
        return $this->preco;
    }

    public function setPreco($preco) {
        $this->preco = $preco;
        return $this;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setIdPlano($id_plano) {
        $this->id_plano = $id_plano;
        return $this;
    }
}

?>