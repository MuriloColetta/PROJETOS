<?php
require_once 'Connection.php';

class AvaliacaoFisicaDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();

        // Garante existência da tabela `avaliacao_fisica` conforme seu schema
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS avaliacao_fisica (
    id_avaliacao INT AUTO_INCREMENT PRIMARY KEY,
    nome_cliente VARCHAR(100) NOT NULL,
    peso_cliente DECIMAL(5,2) NOT NULL,
    altura_cliente DECIMAL(4,2) NOT NULL,
    status_agendamento VARCHAR(50) DEFAULT 'Agendado',
    data_avaliacao DATE NOT NULL
)
SQL;
        $this->conn->exec($sql);
    }

    // CREATE
    public function criarAvaliacao($dados) {
        try {
            $stmt = $this->conn->prepare(<<<'SQL'
INSERT INTO avaliacao_fisica (nome_cliente, peso_cliente, altura_cliente, status_agendamento, data_avaliacao)
VALUES (:nome_cliente, :peso_cliente, :altura_cliente, :status_agendamento, :data_avaliacao)
SQL
            );

            // Preparar datas no formato YYYY-MM-DD - data_avaliacao é obrigatória
            $dataAvaliacao = date('Y-m-d');
            if (isset($dados['dataAvaliacao']) && !empty(trim($dados['dataAvaliacao']))) {
                $d2 = trim($dados['dataAvaliacao']);
                if (preg_match('/^\d{4}-\d{2}-\d{2}/', $d2)) {
                    $dataAvaliacao = substr($d2,0,10);
                } else {
                    $ts2 = strtotime($d2);
                    if ($ts2 !== false) $dataAvaliacao = date('Y-m-d', $ts2);
                }
            }

            // Validar nome obrigatório
            if (!isset($dados['nome']) || empty(trim($dados['nome']))) {
                throw new Exception("Nome do cliente é obrigatório");
            }

            // Converter peso e altura para float
            $peso = null;
            if (isset($dados['peso']) && $dados['peso'] !== '' && $dados['peso'] !== null) {
                $pesoStr = is_string($dados['peso']) ? str_replace(',', '.', trim($dados['peso'])) : $dados['peso'];
                $peso = is_numeric($pesoStr) ? floatval($pesoStr) : null;
            }

            $altura = null;
            if (isset($dados['altura']) && $dados['altura'] !== '' && $dados['altura'] !== null) {
                $alturaStr = is_string($dados['altura']) ? str_replace(',', '.', trim($dados['altura'])) : $dados['altura'];
                $altura = is_numeric($alturaStr) ? floatval($alturaStr) : null;
            }

            $stmt->execute([
                ':nome_cliente' => trim($dados['nome']),
                ':peso_cliente' => $peso,
                ':altura_cliente' => $altura,
                ':status_agendamento' => $dados['status'] ?? 'Agendado',
                ':data_avaliacao' => $dataAvaliacao
            ]);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Erro ao criar avaliação: " . $e->getMessage());
        }
    }

    // READ
    public function lerAvaliacoes() {
        $stmt = $this->conn->query("SELECT * FROM avaliacao_fisica ORDER BY id_avaliacao DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function atualizarAvaliacao($id, $dados) {
        $stmt = $this->conn->prepare(<<<'SQL'
UPDATE avaliacao_fisica
SET nome_cliente = :nome, peso_cliente = :peso, altura_cliente = :altura, status_agendamento = :status, data_avaliacao = :data_avaliacao
WHERE id_avaliacao = :id
SQL
        );
        $stmt->execute([
            ':id' => $id,
            ':nome' => $dados['nome'] ?? '',
            ':peso' => isset($dados['peso']) ? $dados['peso'] : null,
            ':altura' => isset($dados['altura']) ? $dados['altura'] : null,
            ':status' => $dados['status'] ?? 'Agendado',
            ':data_avaliacao' => isset($dados['dataAvaliacao']) ? (substr($dados['dataAvaliacao'],0,10)) : date('Y-m-d')
        ]);
        return $stmt->rowCount() > 0;
    }

    // DELETE
    public function deletarAvaliacao($id) {
        $stmt = $this->conn->prepare("DELETE FROM avaliacao_fisica WHERE id_avaliacao = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    // BUSCAR POR ID
    public function buscarAvaliacao($id) {
        $stmt = $this->conn->prepare("SELECT * FROM avaliacao_fisica WHERE id_avaliacao = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

