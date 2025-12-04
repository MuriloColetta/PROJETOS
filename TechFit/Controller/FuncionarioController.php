<?php
require_once __DIR__ . '../Modal/FuncionarioDAO.php';
require_once __DIR__ . '../Modal/Funcionario.php';

class FuncionarioController {
    private $dao;

    // Construtor: cria o objeto DAO (responsável por salvar/carregar)
    public function __construct() {
        $this->dao = new FuncionarioDAO();
    }

    // Lista todos os funcionarios
    public function ler() {
        return $this->dao->lerFuncionario();
    }

    // Cadastra novo funcionario
    public function criar($nome_funcionario, $cpf_funcionario, $cargo, $salario, $carga_horaria, $email_funcionario, $telefone_funcionario, $senha_funcionario) {

        // // Gera ID automaticamente com base no timestamp (exemplo simples)
        // $id = time(); // Função caso o objeto tenha um atributo de ID

        $funcionario = new Funcionario( $nome_funcionario, $cpf_funcionario, $cargo, $salario, $carga_horaria, $email_funcionario, $telefone_funcionario, $senha_funcionario);
        $this->dao->criarFuncionario($funcionario);
    }

    // Atualiza funcionario existente
    public function atualizar($nome_funcionario, $novoNome_funcionario, $cpf_funcionario, $cargo, $salario, $carga_horaria, $email_funcionario, $telefone_funcionario, $senha_funcionario) {
        $this->dao->atualizarFuncionario($nome_funcionario, $novoNome_funcionario, $cpf_funcionario, $cargo, $salario, $carga_horaria, $email_funcionario, $telefone_funcionario, $senha_funcionario);
    }

    // Exclui funcionario
    public function deletar($nome_funcionario) {
        $this->dao->deletarFuncionario($nome_funcionario);
    }

    // Busca funcionario por nome
    public function buscar($nome_funcionario) {
        return $this->dao->buscarFuncionario($nome_funcionario);
    }

    // LOGIN – AUTENTICAÇÃO
    public function autenticar($nome_funcionario, $senha) {
        if (empty($nome_funcionario) || empty($senha)) {
            return "Preencha seu nome_funcionario e senha.";
        }

        $resultado = $this->dao->autenticar($nome_funcionario, $senha);

        if ($resultado) {
            session_start();
            $_SESSION['funcionario'] = $resultado;
            return true;
        }

        return "Email ou senha incorretos.";
    }

}

?>