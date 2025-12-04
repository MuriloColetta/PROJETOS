<?php
require_once 'Connection.php';

class AvaliacaoFisicaDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();

        // Garante existência da tabela para avaliações do index.html
        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS avaliacao_fisica_site (
                id_avaliacao INT AUTO_INCREMENT PRIMARY KEY,
                tipo VARCHAR(20) NOT NULL DEFAULT 'Avaliação',
                nome_cliente VARCHAR(100) NOT NULL,
                peso DECIMAL(5,2),
                altura DECIMAL(4,2),
                data_avaliacao DATE,
                data_agendamento DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    // CREATE
    public function criarAvaliacao($dados) {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO avaliacao_fisica_site (tipo, nome_cliente, peso, altura, data_avaliacao, data_agendamento)
                VALUES (:tipo, :nome_cliente, :peso, :altura, :data_avaliacao, :data_agendamento)
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
            
            // Converter peso e altura para float, se necessário
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
                ':tipo' => $dados['tipo'] ?? 'Avaliação',
                ':nome_cliente' => trim($dados['nome']),
                ':peso' => $peso,
                ':altura' => $altura,
                ':data_avaliacao' => !empty($dados['dataAvaliacao']) ? $dados['dataAvaliacao'] : null,
                ':data_agendamento' => $dataAgendamento
            ]);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Erro ao criar avaliação: " . $e->getMessage());
        }
    }

    // READ
    public function lerAvaliacoes() {
        $stmt = $this->conn->query("SELECT * FROM avaliacao_fisica_site WHERE tipo = 'Avaliação' ORDER BY id_avaliacao DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function atualizarAvaliacao($id, $dados) {
        $stmt = $this->conn->prepare("
            UPDATE avaliacao_fisica_site
            SET nome_cliente = :nome, peso = :peso, altura = :altura, data_avaliacao = :data_avaliacao
            WHERE id_avaliacao = :id
        ");
        $stmt->execute([
            ':id' => $id,
            ':nome' => $dados['nome'],
            ':peso' => $dados['peso'],
            ':altura' => $dados['altura'],
            ':data_avaliacao' => $dados['dataAvaliacao']
        ]);
        return $stmt->rowCount() > 0;
    }

    // DELETE
    public function deletarAvaliacao($id) {
        $stmt = $this->conn->prepare("DELETE FROM avaliacao_fisica_site WHERE id_avaliacao = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    // BUSCAR POR ID
    public function buscarAvaliacao($id) {
        $stmt = $this->conn->prepare("SELECT * FROM avaliacao_fisica_site WHERE id_avaliacao = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

