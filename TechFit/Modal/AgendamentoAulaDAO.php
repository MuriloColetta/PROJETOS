<?php
require_once 'Connection.php';

class AgendamentoAulaDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();

        // Garante existência da tabela `agendamento` conforme seu schema
        $sql = <<<'SQL'
    CREATE TABLE IF NOT EXISTS agendamento (
        id_agendamento INT AUTO_INCREMENT PRIMARY KEY,
        nome_cliente VARCHAR(100) NOT NULL,
        modalidade VARCHAR(50) NOT NULL,
        horario VARCHAR(50) NOT NULL,
        status_agendamento VARCHAR(50) DEFAULT 'Agendado',
        data_agendamento TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )
    SQL;
        $this->conn->exec($sql);
    }

    // CREATE
    public function criarAgendamento($dados) {
        try {
            // Não enviar data_agendamento no INSERT para que o banco gere automaticamente
            $stmt = $this->conn->prepare(<<<'SQL'
INSERT INTO agendamento (nome_cliente, modalidade, horario, status_agendamento)
VALUES (:nome_cliente, :modalidade, :horario, :status_agendamento)
SQL
            );

            // Validar nome obrigatório
            if (!isset($dados['nome']) || empty(trim($dados['nome']))) {
                throw new Exception("Nome do cliente é obrigatório");
            }

            $stmt->execute([
                ':nome_cliente' => trim($dados['nome']),
                ':modalidade' => !empty($dados['modalidade']) ? trim($dados['modalidade']) : '',
                ':horario' => !empty($dados['horario']) ? trim($dados['horario']) : '',
                ':status_agendamento' => $dados['status'] ?? 'Agendado'
            ]);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Erro ao criar agendamento: " . $e->getMessage());
        }
    }

    // READ
    public function lerAgendamentos() {
        $stmt = $this->conn->query("SELECT * FROM agendamento ORDER BY id_agendamento DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function atualizarAgendamento($id, $dados) {
        // Não sobrescrever data_agendamento aqui — o TIMESTAMP do banco fará o update automático
        $stmt = $this->conn->prepare(<<<'SQL'
        UPDATE agendamento
        SET nome_cliente = :nome, modalidade = :modalidade, horario = :horario, status_agendamento = :status
        WHERE id_agendamento = :id
        SQL
            );
            $stmt->execute([
                ':id' => $id,
                ':nome' => $dados['nome'] ?? '',
                ':modalidade' => $dados['modalidade'] ?? '',
                ':horario' => $dados['horario'] ?? '',
                ':status' => $dados['status'] ?? 'Agendado'
            ]);
        return $stmt->rowCount() > 0;
    }

    // DELETE
    public function deletarAgendamento($id) {
        $stmt = $this->conn->prepare("DELETE FROM agendamento WHERE id_agendamento = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    // BUSCAR POR ID
    public function buscarAgendamento($id) {
        $stmt = $this->conn->prepare("SELECT * FROM agendamento WHERE id_agendamento = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

