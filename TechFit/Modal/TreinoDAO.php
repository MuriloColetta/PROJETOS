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
                nome_treino VARCHAR(50) NOT NULL,
                descricao VARCHAR(255) NOT NULL,
                dias INT NOT NULL
            )
        ");
    }

    // CREATE
    public function criarTreino(Treino $treino) {
        $stmt = $this->conn->prepare("
            INSERT INTO treino (nome_treino, descricao, dias)
            VALUES (:nome_treino, :descricao, :dias)
        ");
        $stmt->execute([
            ':nome_treino' => $treino->getNomeTreino(),
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
            $result[$row['id_treino']] = new Treino(
                $row['id_treino'],
                $row['nome_treino'],
                $row['descricao'],
                $row['dias']
            );
        }
        return $result;
    }

    // UPDATE
    public function atualizarTreino($nome_treinoOriginal, $novoNome_treino, $descricao, $dias) {
        $stmt = $this->conn->prepare("
            UPDATE treino
            SET nome_treino = :novoNome_treino, descricao = :descricao, dias = :dias
            WHERE nome_treino = :nome_treinoOriginal
        ");
        $stmt->execute([
            ':novoNome_treino' => $novoNome_treino,
            ':descricao' => $descricao,
            ':dias' => $dias,
            ':nome_treinoOriginal' => $nome_treinoOriginal,
        ]);
    }

    // DELETE
    public function deletarTreino($nome_treino) {
        $stmt = $this->conn->prepare("
            DELETE FROM treino
            WHERE nome_treino = :nome_treino
        ");
        $stmt->execute([
            ':nome_treino' => $nome_treino,
        ]);
    }

    // Buscar treino por nome
    public function buscarTreino($nome_treino) {
        $stmt = $this->conn->prepare('SELECT * FROM treino WHERE nome_treino = :nome_treino');
        $stmt->execute([':nome_treino' => $nome_treino]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Treino(
                $row['id_treino'],
                $row['nome_treino'],
                $row['descricao'],
                $row['dias']
            );
        } else {
            return null; // Retorna null se o treino não for encontrado
        }
    }
}

?>