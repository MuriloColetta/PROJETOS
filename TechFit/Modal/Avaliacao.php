<?php
class Avaliacao {
    private $id_cliente;
    private $id_funcionario;
    private $data;
    private $descricao;

    public function __construct($id_cliente, $id_funcionario, $data, $descricao) {
        $this->id_cliente = $id_cliente;
        $this->id_funcionario = $id_funcionario;
        $this->data = $data;
        $this->descricao = $descricao;
    }

    public function getIdCliente() {
        return $this->id_cliente;
    }

    public function setIdCliente($id_cliente): self {
        $this->id_cliente = $id_cliente;
        return $this;
    }

    public function getIdFuncionario() {
        return $this->id_funcionario;
    }

    public function setIdFuncionario($id_funcionario): self {
        $this->id_funcionario = $id_funcionario;
        return $this;
    }
    public function getData() {
        return $this->data;
    }

    public function setData($data): self {
        $this->data = $data;
        return $this;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao): self {
        $this->descricao = $descricao;
        return $this;
    }
}

?>