<?php
require_once 'Connection.php';

class AgendamentoAulaDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();

        // Garante existência da tabela para agendamentos do index.html
        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS agendamento_aula (
                id_agendamento INT AUTO_INCREMENT PRIMARY KEY,
                tipo VARCHAR(20) NOT NULL DEFAULT 'Aula',
                nome_cliente VARCHAR(100) NOT NULL,
                modalidade VARCHAR(50),
                horario VARCHAR(100),
                data_agendamento DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    // CREATE
    public function criarAgendamento($dados) {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO agendamento_aula (tipo, nome_cliente, modalidade, horario, data_agendamento)
                VALUES (:tipo, :nome_cliente, :modalidade, :horario, :data_agendamento)
            ");
            
            // Converter data para formato MySQL se necessário
            $dataAgendamento = date('Y-m-d H:i:s');
            if (isset($dados['data']) && !empty($dados['data'])) {
                $dataFornecida = trim($dados['data']);
                // Se a data vier no formato ISO (YYYY-MM-DD HH:MM:SS), usar diretamente
                if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $dataFornecida)) {
                    $dataAgendamento = $dataFornecida;
                } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dataFornecida)) {
                    // Se for apenas data, adicionar hora atual
                    $dataAgendamento = $dataFornecida . ' ' . date('H:i:s');
                }
            }
            
            // Validar nome obrigatório
            if (!isset($dados['nome']) || empty(trim($dados['nome']))) {
                throw new Exception("Nome do cliente é obrigatório");
            }
            
            $stmt->execute([
                ':tipo' => $dados['tipo'] ?? 'Aula',
                ':nome_cliente' => trim($dados['nome']),
                ':modalidade' => !empty($dados['modalidade']) ? trim($dados['modalidade']) : null,
                ':horario' => !empty($dados['horario']) ? trim($dados['horario']) : null,
                ':data_agendamento' => $dataAgendamento
            ]);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Erro ao criar agendamento: " . $e->getMessage());
        }
    }

    // READ
    public function lerAgendamentos() {
        $stmt = $this->conn->query("SELECT * FROM agendamento_aula WHERE tipo = 'Aula' ORDER BY id_agendamento DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function atualizarAgendamento($id, $dados) {
        $stmt = $this->conn->prepare("
            UPDATE agendamento_aula
            SET nome_cliente = :nome, modalidade = :modalidade, horario = :horario
            WHERE id_agendamento = :id
        ");
        $stmt->execute([
            ':id' => $id,
            ':nome' => $dados['nome'],
            ':modalidade' => $dados['modalidade'],
            ':horario' => $dados['horario']
        ]);
        return $stmt->rowCount() > 0;
    }

    // DELETE
    public function deletarAgendamento($id) {
        $stmt = $this->conn->prepare("DELETE FROM agendamento_aula WHERE id_agendamento = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    // BUSCAR POR ID
    public function buscarAgendamento($id) {
        $stmt = $this->conn->prepare("SELECT * FROM agendamento_aula WHERE id_agendamento = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

