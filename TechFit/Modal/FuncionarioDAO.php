<?php
require_once 'Funcionario.php';
require_once 'Connection.php';

class FuncionarioDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();

        //Garante existência da tabela
        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS funcionario (
                id_funcionario INT AUTO_INCREMENT PRIMARY KEY,
                nome_funcionario VARCHAR(50) NOT NULL,
                cpf_funcionario VARCHAR(14) NOT NULL,
                cargo VARCHAR(50) NOT NULL,
                salario DECIMAL(10,2) NOT NULL,
                carga_horaria INT NOT NULL,
                email_funcionario VARCHAR(100) NOT NULL,
                telefone_funcionario VARCHAR(15) NOT NULL,
                senha_funcionario VARCHAR(255) NOT NULL
            )
        ");
    }

    // CREATE
    public function criarFuncionario(Funcionario $funcionario) {
        $stmt = $this->conn->prepare("
            INSERT INTO funcionario (nome_funcionario, cpf_funcionario, cargo, salario, carga_horaria, email_funcionario, telefone_funcionario, senha_funcionario)
            VALUES (:nome_funcionario, :cpf_funcionario, :cargo, :salario, :carga_horaria, :email_funcionario, :telefone_funcionario, :senha_funcionario)
        ");
        $stmt->execute([
            ':nome_funcionario' => $funcionario->getNomeFuncionario(),
            ':cpf_funcionario' => $funcionario->getCpfFuncionario(),
            ':cargo' => $funcionario->getCargo(),
            ':salario' => $funcionario->getSalario(),
            ':carga_horaria' => $funcionario->getCargaHoraria(),
            ':email_funcionario' => $funcionario->getEmailFuncionario(),
            ':telefone_funcionario' => $funcionario->getTelefoneFuncionario(),
            ':senha_funcionario' =>  $funcionario->getSenhaFuncionario(),
        ]);
    }

    // READ
    public function lerFuncionario() {
        $stmt = $this->conn->prepare("SELECT * FROM funcionario ORDER BY id_funcionario");

        $result = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[$row['id_funcionario']] = new Funcionario(
                $row['id_funcionario'],
                $row['nome_funcionario'],
                $row['cpf_funcionario'],
                $row['cargo'],
                $row['salario'],
                $row['carga_horaria'],
                $row['email_funcionario'],
                $row['telefone_funcionario'],
                $row['senha_funcionario']
            );
        }
        return $result;
    }

    // UPDATE
    public function atualizarFuncionario($nome_funcionarioOriginal, $novoNome_funcionario, $cpf_funcionario, $cargo, $salario, $carga_horaria, $email_funcionario, $telefone_funcionario, $senha_funcionario) {
        $stmt = $this->conn->prepare("
            UPDATE funcionario
            SET nome_funcionario = :novoNome, cpf_funcionario = :cpf_funcionario, cargo = :cargo, salario = :salario, carga_horaria = :carga_horaria, email_funcionario = :email_funcionario, telefone_funcionario = :telefone_funcionario, senha_funcionario = :senha_funcionario
            WHERE nome_funcionario = :nome_funcionarioOriginal
        ");
        $stmt->execute([
            ':novoNome' => $novoNome_funcionario,
            ':cpf_funcionario' => $cpf_funcionario,
            ':cargo' => $cargo,
            ':salario' => $salario,
            ':carga_horaria' => $carga_horaria,
            ':email_funcionario' => $email_funcionario,
            ':telefone_funcionario' => $telefone_funcionario,
            ':senha_funcionario' => $senha_funcionario,
            ':nome_funcionarioOriginal' => $nome_funcionarioOriginal
        ]);
    }

    // DELETE
    public function deletarFuncionario($nome_funcionario) {
        $stmt = $this->conn->prepare("
            DELETE FROM funcionario WHERE nome_funcionario = :nome_funcionario
        ");
        $stmt->execute([':nome_funcionario' => $nome_funcionario]);
    }

    // BUSCAR POR NOME FUNCIONARIO
    public function buscarFuncionario($nome_funcionario) {
        $stmt = $this->conn->prepare("SELECT * FROM funcionario WHERE nome_funcionario = :nome_funcionario");
        $stmt->execute([':nome_funcionario' => $nome_funcionario]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Funcionario(
                $row['id_funcionario'],
                $row['nome_funcionario'],
                $row['cpf_funcionario'],
                $row['cargo'],
                $row['salario'],
                $row['carga_horaria'],
                $row['email_funcionario'],
                $row['telefone_funcionario'],
                $row['senha_funcionario']
            );
        }
        return null;
    }

    // LOGIN – AUTENTICAÇÃO
    public function autenticar($nome_funcionario, $senha) {
        $stmt = $this->conn->prepare("
            SELECT * FROM funcionario WHERE nome_funcionario = :nome_funcionario LIMIT 1
        ");
        $stmt->bindParam(':nome_funcionario', $nome_funcionario);
        $stmt->execute();

        $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Comparação simples (sem criptografia)
        if ($funcionario && $senha === $funcionario['senha_funcionario']) {
            return $funcionario;
        }

        return false;
    }
}

?>