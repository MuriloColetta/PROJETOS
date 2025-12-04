<?php
class Avaliacao {
    private $id_avaliacao;
    private $id_cliente;
    private $id_funcionario;
    private $peso_cliente;
    private $altura_cliente;
    private $data_avaliacao;
    private $descricao;

    public function __construct($id_avaliacao, $id_cliente, $id_funcionario, $peso_cliente, $altura_cliente, $data_avaliacao, $descricao) {
        $this->id_avaliacao = $id_avaliacao;
        $this->id_cliente = $id_cliente;
        $this->id_funcionario = $id_funcionario;
        $this->peso_cliente = $peso_cliente;
        $this->altura_cliente = $altura_cliente;
        $this->data_avaliacao = $data_avaliacao;
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

    public function getPeso() {
        return $this->peso_cliente;
    }

    public function setPeso($peso): self {
        $this->peso_cliente = $peso;
        return $this;
    }

    public function getAltura() {
        return $this->altura_cliente;
    }

    public function setAltura($altura): self {
        $this->altura_cliente = $altura;
        return $this;
    }

    public function getDataAvaliacao() {
        return $this->data_avaliacao;
    }

    public function setData($data_avaliacao): self {
        $this->data_avaliacao = $data_avaliacao;
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