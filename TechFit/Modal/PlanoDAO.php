<?php 
require_once 'Plano.php';
require_once 'Connection.php';

class PlanoDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();

        // Garante existência da tabela
        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS plano (
                id_plano INT AUTO_INCREMENT PRIMARY KEY,
                nome_plano VARCHAR(50) NOT NULL,
                preco DECIMAL(10,2) NOT NULL,
                descricao VARCHAR(255) NOT NULL
            )
        ");
    }

    // CREATE
    public function criarPlano(Plano $plano) {
        $stmt = $this->conn->prepare("
            INSERT INTO plano (nome_plano, preco, descricao)
            VALUES (:nome_plano, :preco, :descricao)");
            $stmt->execute([
                ':nome_plano' => $plano->getNomePlano(),
                ':preco' => $plano->getPreco(),
                ':descricao' => $plano->getDescricao()]);
    }

    // READ
    public function lerPlano() {
        $stmt = $this->conn->query("SELECT * FROM plano ORDER BY id_plano");

        $result = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[$row['id_plano']] = new Plano(
                $row['id_plano'],
                $row['nome_plano'],
                $row['preco'],
                $row['descricao']
            );
        }
        return $result;
    }

    //UPDATE
    public function atualizarPlano($nome_planoOriginal, $novoNome_plano, $preco, $descricao) {
        $stmt = $this->conn->prepare("
        UPDATE plano
        SET nome_plano = :novoNome_plano, preco = :preco, dascricao = :descricao
        WHERE nome_plano = :nome_planoOriginal");

        $stmt->execute([
            ':novoNome_plano' => $novoNome_plano,
            ':preco' => $preco,
            'descricao'=> $descricao,
            ':nome_planoOriginal' => $nome_planoOriginal
        ]);
    }

    //DELETE
    public function deletarPlano($nome_plano){
        $stmt = $this->conn->prepare("
        DELETE FROM plano
        WHERE nome_plano = :nome_plano");
        $stmt->execute([':nome_plano' => $nome_plano]);
    }

    // BUSCAR POR NOME
    public function buscarPlano($nome_plano) {
        $stmt = $this->conn->prepare("SELECT * FROM plano WHERE nome_plano = :nome_plano");
        $stmt->execute([':nome_plano' => $nome_plano]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Plano(
                $row['id_plano'],
                $row['nome_plano'],
                $row['preco'],
                $row['descricao']
            );
        }
        return null;
    }
}

?>