<?php 
require_once 'Assinatura.php';
require_once 'Connection.php';

class AssinaturaDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();

        // Garante existência da tabela
        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS assinatura (
                id_cliente INT NOT NULL,
                id_plano INT NOT NULL,
                PRIMARY KEY (id_cliente, id_plano)
            )
        ");
    }

    // CREATE
    public function criarAssinatura(Assinatura $assinatura) {
        $stmt = $this->conn->prepare("
            INSERT INTO assinatura (id_cliente, id_plano)
            VALUES (:id_cliente, :id_plano)");
            $stmt->execute([
                ':id_cliente' => $assinatura->getIdCliente(),
                ':id_plano' => $assinatura->getIdPlano()]);
    }

    // READ
    public function lerAssinatura() {
        $stmt = $this->conn->query("SELECT * FROM assinatura ORDER BY id_assinatura");

        $result = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[$row['id_assinatura']] = new Assinatura(
                $row['id_assinatura'],
                $row['id_cliente'],
                $row['id_plano']
            );
        }
        return $result;
    }

    //UPDATE
    public function atualizarAssinatura($id_clienteOriginal, $novoId_cliente, $id_plano){
        $stmt = $this->conn->prepare("
        UPDATE assinatura
        SET id_cliente = :novoId_cliente, id_plano = :id_plano
        WHERE id_cliente = :id_clienteOriginal");

        $stmt->execute([
            ':novoId_cliente' => $novoId_cliente,
            ':id_plano' => $id_plano,
            ':id_clienteOriginal' => $id_clienteOriginal
        ]);
    }

    //DELETE
    public function deletarAssinatura($id_cliente){
        $stmt = $this->conn->prepare("
        DELETE FROM assinatura
        WHERE id_cliente = :id_cliente");
        $stmt->execute([':id_cliente' => $id_cliente]);
    }

    // BUSCAR POR Id Cliente
    public function buscarAssinatura($id_cliente) {
        $stmt = $this->conn->prepare("SELECT * FROM assinatura WHERE id_cliente = :id_cliente");
        $stmt->execute([':id_cliente' => $id_cliente]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Assinatura(
                $row['id_assinatura'],
                $row['id_cliente'],
                $row['id_plano']
            );
        }
        return null;
    }
}
?>