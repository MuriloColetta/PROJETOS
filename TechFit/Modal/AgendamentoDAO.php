<?php
require_once __DIR__ . 'Agendamento.php';
require_once __DIR__ . 'Connection.php';

class AgendamentoDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();

        // Garante existência da tabela
        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS agendamento (
                id_agendamento INT AUTO_INCREMENT PRIMARY KEY,
                status_agendamento VARCHAR(20) DEFAULT 'Agendado',
                id_cliente INT NOT NULL,
                id_aula INT NOT NULL,
                data_agendamento TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )");
    }

    // CREATE
    public function criarAgendamento(Agendamento $agendamento) {
        // Não inserir data_agendamento — o banco preenche automaticamente
        $stmt = $this->conn->prepare("
            INSERT INTO agendamento(status_agendamento, id_cliente, id_aula)
            VALUES (:status_agendamento, :id_cliente, :id_aula)");
        $stmt->execute([
            ':status_agendamento' => $agendamento->getStatus(),
            ':id_cliente'=> $agendamento->getIdCliente(),
            ':id_aula'=> $agendamento->getIdAula()
        ]);
    }

    // READ
    public function lerAgendamento() {
        $stmt = $this->conn->query("SELECT * FROM agendamento ORDER BY id_agendamento");

        $result = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[$row['id_agendamento']] = new Agendamento(
                $row['id_agendamento'],
                $row['status_agendamento'],
                $row['id_cliente'],
                $row['id_aula']
            );
        }
        return $result;
    }

    //UPDATE
    public function atualizarAgendamento($id_agendamento, $novoId_cliente, $status_agendamento, $id_aula) {
        // Não sobrescrever data_agendamento — TIMESTAMP no DB atualiza automaticamente
        $stmt = $this->conn->prepare("
        UPDATE agendamento
        SET id_cliente = :novoId_cliente, status_agendamento = :status_agendamento, id_aula = :id_aula
        WHERE id_agendamento = :id_agendamento");

        $stmt->execute([
            ':novoId_cliente' => $novoId_cliente,
            ':status_agendamento'=> $status_agendamento,
            ':id_aula'=> $id_aula,
            ':id_agendamento' => $id_agendamento
        ]);
    }

    // DELETE
    public function deletarAgendamento($id_agendamento) {
        $stmt = $this->conn->prepare("
        DELETE FROM agendamento
        WHERE id_agendamento = :id_agendamento");
        $stmt->execute([':id_agendamento' => $id_agendamento]);
    }

    // BUSCAR POR ID CLIENTE
    public function buscarAgendamento($id_agendamento) {
        $stmt = $this->conn->prepare("SELECT * FROM agendamento WHERE id_agendamento = :id_agendamento");
        $stmt->execute([':id_agendamento' => $id_agendamento]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Agendamento(
                $row['id_agendamento'],
                $row['status_agendamento'],
                $row['id_cliente'],
                $row['id_aula']
            );
        }
        return null;
    }
}

?>