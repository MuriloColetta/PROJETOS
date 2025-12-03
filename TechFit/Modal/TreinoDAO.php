<?php
require_once 'Treino.php';
require_once 'Connection.php';

class TreinoDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();

        //Garante existência da tabela
        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS treino (
                id_treino INT AUTO_INCREMENT PRIMARY KEY,
                descricao VARCHAR(255) NOT NULL,
                dias INT NOT NULL
            )
        ");
    }

    // CREATE
    public function criarTreino(Treino $treino) {
        $stmt = $this->conn->prepare("
            INSERT INTO treino (descricao, dias)
            VALUES (:descricao, :dias)
        ");
        $stmt->execute([
            ':descricao' => $treino->getDescricao(),
            ':dias' => $treino->getDias(),
        ]);
    }

    // READ
    public function lerTreino() {
        $stmt = $this->conn->prepare("SELECT * FROM treino ORDER BY id_treino");
        $stmt->execute();

        $result = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[$row['descricao']] = new Treino(
                $row['descricao'],
                $row['dias']
            );
        }
        return $result;
    }

    // UPDATE
    public function atualizarTreino($descricaoOriginal, $novaDescricao, $dias) {
        $stmt = $this->conn->prepare("
            UPDATE treino
            SET descricao = :novaDescricao, dias = :dias
            WHERE descricao = :descricaoOriginal
        ");
        $stmt->execute([
            ':novaDescricao' => $novaDescricao,
            ':dias' => $dias,
            ':descricaoOriginal' => $descricaoOriginal,
        ]);
    }

    // DELETE
    public function deletarTreino($descricao) {
        $stmt = $this->conn->prepare("
            DELETE FROM treino
            WHERE descricao = :descricao
        ");
        $stmt->execute([
            ':descricao' => $descricao,
        ]);
    }
}   

?>