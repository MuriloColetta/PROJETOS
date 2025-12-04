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
                id_aula INT NOT NULL
            )");
    }

    // CREATE
    public function criarAgendamento(Agendamento $agendamento) {
        $stmt = $this->conn->prepare("
            INSERT INTO agendamento(status_agendamento, id_cliente, id_aula)
            VALUES (:status_agendamento, :id_cliente, :id_aula)");
            $stmt->execute([
                ':status_agendamento' => $agendamento->getStatus(),
                ':id_cliente'=> $agendamento->getIdCliente(),
                'id_aula'=> $agendamento->getIdAula()]);
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
    public function atualizarAgendamento($id_clienteOriginal, $novoId_cliente, $status_agendamento, $id_aula) {
        $stmt = $this->conn->prepare("
        UPDATE agendamento
        SET id_cliente = novoId_cliente, status_agendamento = :status_agendamento, id_aula = :id_aula");

        $stmt->execute([
            ':novoId_cliente' => $novoId_cliente,
            ':status_agendamento'=> $status_agendamento,
            ':id_aula'=> $id_aula,
            ':id_clienteOriginal' => $id_clienteOriginal
        ]);
    }

    // DELETE
    public function deletarAgendamento($id_cliente) {
        $stmt = $this->conn->prepare("
        DELETE FROM agendamento
        WHERE id_cliente = :id_cliente");
        $stmt->execute([':id_cliente' => $id_cliente]);
    }

    // BUSCAR POR ID CLIENTE
    public function buscarAgendamento($id_cliente) {
        $stmt = $this->conn->prepare("SELECT * FROM agendamento WHERE id_cliente = :id_cliente");
        $stmt->execute(["id_cliente"=> $id_cliente]);
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