<?php
require_once __DIR__ . '/../Modal/ClienteDAO.php';
require_once __DIR__ . '/../Modal/Cliente.php';

class ClienteController {
    private $dao;

    // Construtor: cria o objeto DAO (responsável por salvar/carregar)
    public function __construct() {
        $this->dao = new ClienteDAO();
    }

    // Lista todas as clientes
    public function ler() {
        return $this->dao->lerCliente();
    }

    // Cadastra nova cliente
    public function criar($nome_cliente, $cpf_cliente, $data_nascimento, $email_cliente, $telefone_cliente, $senha_cliente) {

        // // Gera ID automaticamente com base no timestamp (exemplo simples)
        // $id = time(); // Função caso o objeto tenha um atributo de ID

        $cliente = new Cliente( $nome_cliente, $cpf_cliente, $data_nascimento, $email_cliente, $telefone_cliente, $senha_cliente);
        $this->dao->criarCliente($cliente);
    }

    // Atualiza cliente existente
    public function atualizar($nome_cliente, $novoNome_cliente, $cpf_cliente, $data_nascimento, $email_cliente, $telefone_cliente, $senha_cliente) {
        $this->dao->atualizarCliente($nome_cliente, $novoNome_cliente, $cpf_cliente, $data_nascimento, $email_cliente, $telefone_cliente, $senha_cliente);
    }

    // Exclui cliente
    public function deletar($nome_cliente) {
        $this->dao->deletarCliente($nome_cliente);
    }

    // Busca cliente por nome
    public function buscar($nome_cliente) {
        return $this->dao->buscarCliente($nome_cliente);
    }

    // LOGIN – AUTENTICAÇÃO
    public function autenticar($nome_cliente, $senha) {
        if (empty($nome_cliente) || empty($senha)) {
            return "Preencha todos os campos.";
        }

        $resultado = $this->dao->autenticar($nome_cliente, $senha);

        if ($resultado) {
            session_start();
            $_SESSION['cliente'] = $resultado;
            return true;  
        }

        return "Email ou senha incorretos.";
    }

}

?>