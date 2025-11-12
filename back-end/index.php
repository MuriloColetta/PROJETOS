<?php

class Cliente {
    private $id_cliente;
    private $nome_cliente;
    private $cpf;
    private $data_nascimento;
    private $email;
    private $telefone;

    public function __construct($nome_cliente="", $cpf="", $data_nascimento="", $email="", $telefone="") {
        $this->nome_cliente = $nome_cliente;
        $this->cpf = $cpf;
        $this->data_nascimento = $data_nascimento;
        $this->email = $email;
        $this->telefone = $telefone;
    }

    public function getIdCliente() { return $this->id_cliente; }
    public function getNomeCliente() { return $this->nome_cliente; }
    public function getCpf() { return $this->cpf; }
    public function getDataNascimento() { return $this->data_nascimento; }
    public function getEmail() { return $this->email; }
    public function getTelefone() { return $this->telefone; }

    public function setIdCliente($id_cliente) { $this->id_cliente = $id_cliente; }
    public function setNomeCliente($nome_cliente) { $this->nome_cliente = $nome_cliente; }
    public function setCpf($cpf) { $this->cpf = $cpf; }
    public function setDataNascimento($data_nascimento) { $this->data_nascimento = $data_nascimento; }
    public function setEmail($email) { $this->email = $email; }
    public function setTelefone($telefone) { $this->telefone = $telefone; }
}
class Funcionario {
    private $id_funcionario;
    private $nome_funcionario;
    private $cpf;
    private $cargo;
    private $salario;
    private $carga_horaria;
    private $email;
    private $telefone;

    public function __construct($nome_funcionario="", $cpf="", $cargo="", $salario=0, $carga_horaria=0, $email="", $telefone="") {
        $this->nome_funcionario = $nome_funcionario;
        $this->cpf = $cpf;
        $this->cargo = $cargo;
        $this->salario = $salario;
        $this->carga_horaria = $carga_horaria;
        $this->email = $email;
        $this->telefone = $telefone;
    }

    public function getIdFuncionario() { return $this->id_funcionario; }
    public function getNomeFuncionario() { return $this->nome_funcionario; }
    public function getCpf() { return $this->cpf; }
    public function getCargo() { return $this->cargo; }
    public function getSalario() { return $this->salario; }
    public function getCargaHoraria() { return $this->carga_horaria; }
    public function getEmail() { return $this->email; }
    public function getTelefone() { return $this->telefone; }

    public function setIdFuncionario($id_funcionario) { $this->id_funcionario = $id_funcionario; }
    public function setNomeFuncionario($nome_funcionario) { $this->nome_funcionario = $nome_funcionario; }
    public function setCpf($cpf) { $this->cpf = $cpf; }
    public function setCargo($cargo) { $this->cargo = $cargo; }
    public function setSalario($salario) { $this->salario = $salario; }
    public function setCargaHoraria($carga_horaria) { $this->carga_horaria = $carga_horaria; }
    public function setEmail($email) { $this->email = $email; }
    public function setTelefone($telefone) { $this->telefone = $telefone; }
}

class Suporte {
    private $id_suporte;
    private $descricao;
    private $categoria;
    private $status_suporte;

    public function __construct($descricao="", $categoria="", $status_suporte="ativo") {
        $this->descricao = $descricao;
        $this->categoria = $categoria;
        $this->status_suporte = $status_suporte;
    }

    public function getIdSuporte() { return $this->id_suporte; }
    public function getDescricao() { return $this->descricao; }
    public function getCategoria() { return $this->categoria; }
    public function getStatusSuporte() { return $this->status_suporte; }

    public function setIdSuporte($id_suporte) { $this->id_suporte = $id_suporte; }
    public function setDescricao($descricao) { $this->descricao = $descricao; }
    public function setCategoria($categoria) { $this->categoria = $categoria; }
    public function setStatusSuporte($status_suporte) { $this->status_suporte = $status_suporte; }
}

class Plano {
    private $id_plano;
    private $nome_plano;
    private $preco;
    private $descricao;

    public function __construct($nome_plano="", $preco=0, $descricao="") {
        $this->nome_plano = $nome_plano;
        $this->preco = $preco;
        $this->descricao = $descricao;
    }

    public function getIdPlano() { return $this->id_plano; }
    public function getNomePlano() { return $this->nome_plano; }
    public function getPreco() { return $this->preco; }
    public function getDescricao() { return $this->descricao; }

    public function setIdPlano($id_plano) { $this->id_plano = $id_plano; }
    public function setNomePlano($nome_plano) { $this->nome_plano = $nome_plano; }
    public function setPreco($preco) { $this->preco = $preco; }
    public function setDescricao($descricao) { $this->descricao = $descricao; }
}

class Filiais {
    private $id_filiais;
    private $cnpj;
    private $endereco;

    public function __construct($cnpj="", $endereco="") {
        $this->cnpj = $cnpj;
        $this->endereco = $endereco;
    }

    public function getIdFiliais() { return $this->id_filiais; }
    public function getCnpj() { return $this->cnpj; }
    public function getEndereco() { return $this->endereco; }

    public function setIdFiliais($id_filiais) { $this->id_filiais = $id_filiais; }
    public function setCnpj($cnpj) { $this->cnpj = $cnpj; }
    public function setEndereco($endereco) { $this->endereco = $endereco; }
}
class Aula {
    private $id_aula;
    private $modalidade;
    private $data_hora;

    public function __construct($modalidade="", $data_hora="") {
        $this->modalidade = $modalidade;
        $this->data_hora = $data_hora;
    }

    public function getIdAula() { return $this->id_aula; }
    public function getModalidade() { return $this->modalidade; }
    public function getDataHora() { return $this->data_hora; }

    public function setIdAula($id_aula) { $this->id_aula = $id_aula; }
    public function setModalidade($modalidade) { $this->modalidade = $modalidade; }
    public function setDataHora($data_hora) { $this->data_hora = $data_hora; }
}
class Treino {
    private $id_treino;
    private $carga_horaria;
    private $descricao;

    public function __construct($carga_horaria=0, $descricao="") {
        $this->carga_horaria = $carga_horaria;
        $this->descricao = $descricao;
    }

    public function getIdTreino() { return $this->id_treino; }
    public function getCargaHoraria() { return $this->carga_horaria; }
    public function getDescricao() { return $this->descricao; }

    public function setIdTreino($id_treino) { $this->id_treino = $id_treino; }
    public function setCargaHoraria($carga_horaria) { $this->carga_horaria = $carga_horaria; }
    public function setDescricao($descricao) { $this->descricao = $descricao; }
}
class AvaliacaoFisica {
    private $id_avaliacao;
    private $data;
    private $descricao;
    private $id_cliente;
    private $id_funcionario;

    public function __construct($data="", $descricao="", $id_cliente=0, $id_funcionario=0) {
        $this->data = $data;
        $this->descricao = $descricao;
        $this->id_cliente = $id_cliente;
        $this->id_funcionario = $id_funcionario;
    }

    public function getIdAvaliacao() { return $this->id_avaliacao; }
    public function getData() { return $this->data; }
    public function getDescricao() { return $this->descricao; }
    public function getIdCliente() { return $this->id_cliente; }
    public function getIdFuncionario() { return $this->id_funcionario; }

    public function setIdAvaliacao($id_avaliacao) { $this->id_avaliacao = $id_avaliacao; }
    public function setData($data) { $this->data = $data; }
    public function setDescricao($descricao) { $this->descricao = $descricao; }
    public function setIdCliente($id_cliente) { $this->id_cliente = $id_cliente; }
    public function setIdFuncionario($id_funcionario) { $this->id_funcionario = $id_funcionario; }
}
class Acesso {
    private $id_acesso;
    private $data;
    private $id_cliente;
    private $id_filiais;

    public function __construct($data="", $id_cliente=0, $id_filiais=0) {
        $this->data = $data;
        $this->id_cliente = $id_cliente;
        $this->id_filiais = $id_filiais;
    }

    public function getIdAcesso() { return $this->id_acesso; }
    public function getData() { return $this->data; }
    public function getIdCliente() { return $this->id_cliente; }
    public function getIdFiliais() { return $this->id_filiais; }

    public function setIdAcesso($id_acesso) { $this->id_acesso = $id_acesso; }
    public function setData($data) { $this->data = $data; }
    public function setIdCliente($id_cliente) { $this->id_cliente = $id_cliente; }
    public function setIdFiliais($id_filiais) { $this->id_filiais = $id_filiais; }
}

class Agendamento {
    private $id_agendamento;
    private $status_agendamento;
    private $id_cliente;
    private $id_aula;

    public function __construct($status_agendamento="", $id_cliente=0, $id_aula=0) {
        $this->status_agendamento = $status_agendamento;
        $this->id_cliente = $id_cliente;
        $this->id_aula = $id_aula;
    }

    public function getIdAgendamento() { return $this->id_agendamento; }
    public function getStatusAgendamento() { return $this->status_agendamento; }
    public function getIdCliente() { return $this->id_cliente; }
    public function getIdAula() { return $this->id_aula; }

    public function setIdAgendamento($id_agendamento) { $this->id_agendamento = $id_agendamento; }
    public function setStatusAgendamento($status_agendamento) { $this->status_agendamento = $status_agendamento; }
    public function setIdCliente($id_cliente) { $this->id_cliente = $id_cliente; }
    public function setIdAula($id_aula) { $this->id_aula = $id_aula; }
}

?>
