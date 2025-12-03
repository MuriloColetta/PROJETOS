<?php
class Funcionario {
    private $nome_funcionario;
    private $cpf_funcionario;
    private $cargo;
    private $salario;
    private $carga_horaria;
    private $email_funcionario;
    private $telefone_funcionario;
    private $senha_funcionario;

    public function __construct($nome_funcionario, $cpf_funcionario, $cargo, $salario, $carga_horaria, $email_funcionario, $telefone_funcionario, $senha_funcionario) {
        $this->nome_funcionario = $nome_funcionario;
        $this->cpf_funcionario = $cpf_funcionario;
        $this->cargo = $cargo;
        $this->salario = $salario;
        $this->carga_horaria = $carga_horaria;
        $this->email_funcionario = $email_funcionario;
        $this->telefone_funcionario = $telefone_funcionario;
        $this->senha_funcionario = $senha_funcionario;
    }

    public function getNomeFuncionario() {
        return $this->nome_funcionario;
    }

    public function setFuncionario($nome_funcionario) {
        $this->nome_funcionario = $nome_funcionario;
        return $this;
    }

    public function getCpfFuncionario() {
        return $this->cpf_funcionario;
    }

    public function setCpfFuncionario($cpf_funcionario) {
        $this->cpf_funcionario = $cpf_funcionario;
        return $this;
    }

    public function getCargo() {
        return $this->cargo;
    }

    public function setCargo($cargo) {
        $this->cargo = $cargo;
        return $this;
    }

    public function getSalario() {
        return $this->salario;
    }

    public function setSalario($salario) {
        $this->salario = $salario;
        return $this;
    }

    public function getCargaHoraria() {
        return $this->carga_horaria;
    }

    public function setCargaHoraria($cargaHoraria) {
        $this->carga_horaria = $cargaHoraria;
        return $this;
    }

    public function getEmailFuncionario() {
        return $this->email_funcionario;
    }

    public function setEmailFuncionario($email_funcionario) {
        $this->email_funcionario = $email_funcionario;
        return $this;
    }

    public function getTelefoneFuncionario() {
        return $this->telefone_funcionario;
    }

    public function setTelefoneFuncionario($telefone_funcionario) {
        $this->telefone_funcionario = $telefone_funcionario;
        return $this;
    }

    public function getSenhaFuncionario() {
        return $this->senha_funcionario;
    }

    public function setSenhaFuncionario($senha_funcionario) {
        $this->senha_funcionario = $senha_funcionario;
        return $this;
    }
}
?>