<?php
require_once 'Avaliacao.php';
require_once 'Connection.php';

class AvaliacaoDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();

        // Garante existência da tabela
        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS avaliacao_fisica (
                id_avaliacao INT AUTO_INCREMENT PRIMARY KEY,
                id_cliente INT NOT NULL,
                id_funcionario INT NOT NULL,
                data DATE NOT NULL,
                descricao VARCHAR(255) NOT NULL
            )"
        );
    }

    // CREATE
    public function criarAvaliacao(Avaliacao $avaliacao) {
        $stmt = $this->conn->prepare("
        INSERT INTO avaliacao_fisica (id_cliente, id_funcionario, data, descricao)
        VALUES (:id_cliente, :id_funcionario :data, :descricao)
        ");
        $stmt->execute([
            ':id_cliente' => $avaliacao->getIdCliente(),
            ':id_funcionario' => $avaliacao->getIdFuncionario(),
            ':data' => $avaliacao->getData(),
            ':descricao' => $avaliacao->getDescricao()
        ]);
    }

    // READ
    public function lerAvaliacao() {
        $stmt = $this->conn->query("SELECT * FROM avaliacao_fisica ORDER BY id_avaliacao");

        $result = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Avaliacao(
                $row['id_cliente'],
                $row['id_funcionario'],
                $row['data'],
                $row['descricao']
            );
        }
        return $result;
    }

    // UPDATE
    public function atualizarAvaliacao($id_clienteOriginal, $novoId_cliente, $id_funcionario, $data, $descricao) {
        $stmt = $this->conn->prepare("
        UPDATE avaliacao_fisica
        SET id_cliente = :novoId_cliente, id_funcionario = :id_funcionario, data = :data, descricao = :descricao 
        WHERE id_cliente = :id_clienteOriginal
        ");
        $stmt->execute([
            ':novoId_cliente' => $novoId_cliente,
            ':id_funcionario' => $id_funcionario,
            ':data' => $data,
            ':descricao' => $descricao,
            ':id_clienteOriginal' => $id_clienteOriginal
        ]);
    }

    // DELETE
    public function deletarAvaliacao($id_cliente) {
        $stmt = $this->conn->prepare("
        DELETE FROM avaliacao_fisica WHERE id_cliente = :id_cliente
        ");
        $stmt->execute([':id_cliente' => $id_cliente]);
    }

    // BUSCAR POR ID CLIENTE
    public function buscarPorIdCliente($id_cliente){
        $stmt = $this->conn->prepare("SELECT * FROM  avaliacao_fisica WHERE id_cliente = :id_cliente");
        $stmt->execute([':id_cliente' => $id_cliente]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Avaliacao(
                $row['id_cliente'],
                $row['id_funcionario'],
                $row['data'],
                $row['descricao']
            );
        }
        return null;
    }
}

?>