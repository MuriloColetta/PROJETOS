<?php
class Cliente {
    private $nome_cliente;
    private $cpf_cliente;
    private $data_nascimento;
    private $email_cliente;
    private $telefone_cliente;
    private $senha_cliente;

    public function __construct($nome_cliente, $cpf_cliente, $data_nascimento, $email_cliente, $telefone_cliente, $senha_cliente) {
        $this->nome_cliente = $nome_cliente;
        $this->cpf_cliente = $cpf_cliente;
        $this->data_nascimento = $data_nascimento;
        $this->email_cliente = $email_cliente;
        $this->telefone_cliente = $telefone_cliente;
        $this->senha_cliente = $senha_cliente;
    }

    public function getNomeCliente() {
        return $this->nome_cliente;
    }

    public function setNomeCliente($nome_cliente): self {
        $this->nome_cliente = $nome_cliente;
        return $this;
    }

    public function getCpfCliente() {
        return $this->cpf_cliente;
    }

    public function setCpfCliente($cpf_cliente): self {
        $this->cpf_cliente = $cpf_cliente;
        return $this;
    }

    public function getDataNascimento() {
        return $this->data_nascimento;
    }

    public function setDataNascimento($data_nascimento): self {
        $this->data_nascimento = $data_nascimento;
        return $this;
    }

    public function getEmailCliente() {
        return $this->email_cliente;
    }

    public function setEmailCliente($email_cliente): self {
        $this->email_cliente = $email_cliente;
        return $this;
    }

    public function getTelefoneCliente() {
        return $this->telefone_cliente;
    }

    public function setTelefoneCliente($telefone_cliente): self {
        $this->telefone_cliente = $telefone_cliente;
        return $this;
    }

    public function getSenhaCliente() {
        return $this->senha_cliente;
    }

    public function setSenhaCliente($senha_cliente): self {
        $this->senha_cliente = $senha_cliente;
        return $this;
    }
}

?>