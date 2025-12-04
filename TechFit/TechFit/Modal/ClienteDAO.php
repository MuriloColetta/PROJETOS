<?php
require_once 'Cliente.php';
require_once 'Connection.php';

class ClienteDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();

        //Garante existência da tabela
        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS cliente (
                id_cliente INT AUTO_INCREMENT PRIMARY KEY,
                nome_cliente VARCHAR(50) NOT NULL,
                cpf_cliente VARCHAR(14) NOT NULL,
                data_nascimento DATA NOT NULL,
                email_cliente VARCHAR(100) NOT NULL,telefone_cliente VARCHAR(15) NOT NULL,
                senha_cliente VARCHAR(255) NOT NULL
            )
        ");
    }

    // CREATE
    public function criarCliente(Cliente $cliente) {
        $stmt = $this->conn->prepare("
            INSERT INTO cliente (nome_cliente, cpf_cliente, data_nascimento, email_cliente, telefone_cliente, senha_cliente)
            VALUES (:nome_cliente, :cpf_cliente, :data_nascimento, :email_cliente, :telefone_cliente, :senha_cliente)
        ");
        $stmt->execute([
            ':nome_cliente' => $cliente->getNomeCliente(),
            ':cpf_cliente' => $cliente->getCpfCliente(),
            ':data_nascimento' => $cliente->getDataNascimento(),
            ':email_cliente' => $cliente->getEmailCliente(),
            ':telefone_cliente' => $cliente->getTelefoneCliente(),
            ':senha_cliente' =>  $cliente->getSenhaCliente(),
        ]);
    }

    // READ
    public function LerCliente() {
        $stmt = $this->conn->prepare("SELECT * FROM cliente ORDER BY id_cliente");

        $result = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[$row['id_cliente']] = new Cliente(
                $row['id_cliente'],
                $row['nome_cliente'],
                $row['cpf_cliente'],
                $row['data_nascimento'],
                $row['email_cliente'],
                $row['telefone_cliente'],
                $row['senha_cliente']
            );
        }
        return $result;
    }

    // UPDATE
    public function atualizarCliente($nome_clienteOriginal, $novoNome_cliente, $cpf_cliente, $data_nascimento, $email_cliente, $telefone_cliente, $senha_cliente) {
        $stmt = $this->conn->prepare("
            UPDATE cliente
            SET nome_cliente = :novoNome, cpf_cliente = :cpf_cliente, data_nascimento = :data_nascimento, email_cliente = :email_cliente, telefone_cliente = :telefone_cliente, senha_cliente = :senha_cliente
            WHERE nome_cliente = :nome_clienteOriginal
        ");

        $stmt->execute([
            ':novoNome' => $novoNome_cliente,
            ':cpf_cliente' => $cpf_cliente,
            ':data_nascimento' => $data_nascimento,
            ':email_cliente' => $email_cliente,
            ':telefone_cliente' => $telefone_cliente,
            ':senha_cliente' => $senha_cliente,
            ':nome_clienteOriginal' => $nome_clienteOriginal
        ]);
    }

    // DELETE
    public function deletarCliente($nome_cliente) {
        $stmt = $this->conn->prepare("
            DELETE FROM cliente WHERE nome_cliente = :nome_cliente
        ");
        $stmt->execute([':nome_cliente' => $nome_cliente]);
    }

    // BUSCAR POR NOME CLIENTE
    public function buscarCliente($nome_cliente) {
        $stmt = $this->conn->prepare("SELECT * FROM cliente WHERE nome_cliente = :nome_cliente");
        $stmt->execute([':nome_cliente' => $nome_cliente]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Cliente(
                $row['id_cliente'],
                $row['nome_cliente'],
                $row['cpf_cliente'],
                $row['data_nascimento'],
                $row['email_cliente'],
                $row['telefone_cliente'],
                $row['senha_cliente'],
            );
        }
        return null;
    }
}

?>