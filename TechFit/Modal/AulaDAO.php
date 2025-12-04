<?php 
require_once 'Aula.php';
require_once 'Connection.php';

class AulaDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connection::getInstance();

        // Garante existência da tabela
        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS aula (
                id_aula INT AUTO_INCREMENT PRIMARY KEY,
                modalidade VARCHAR(50) NOT NULL,
                data_hora VARCHAR(50) NOT NULL
            )
        ");
    }

    // CREATE
    public function criarAula(Aula $aula) {
        $stmt = $this->conn->prepare("
            INSERT INTO aula (modalidade, data_hora)
            VALUES (:modalidade, :data_hora)");
            $stmt->execute([
                ':modalidade' => $aula->getModalidade(),
                ':data_hora' => $aula->getDataHora()]);
    }

    // READ
    public function lerAula() {
        $stmt = $this->conn->query("SELECT * FROM aula ORDER BY id_aula");

        $result = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[$row['id_aula']] = new Aula(
                $row['id_aula'],
                $row['modalidade'],
                $row['data_hora']
            );
        }

        return $result;
    }

    //UPDATE
    public function atualizarAula($modalidadeOriginal, $novaModalidade, $data_hora){
        $stmt = $this->conn->prepare("
        UPDATE aula
        SET modalidade = :novaModalidade, data_hora = :data_hora
        WHERE modalidade = :modalidadeOriginal");

        $stmt->execute([
            ':novaModalidade' => $novaModalidade,
            ':data_hora' => $data_hora,
            ':modalidadeOriginal' => $modalidadeOriginal
        ]);
    }

    //DELETE
    public function deletarAula($modalidade){
        $stmt = $this->conn->prepare("
        DELETE FROM aula
        WHERE modalidade = :modalidade");
        $stmt->execute([':modalidade' => $modalidade]);
    }

    // BUSCAR POR MODALIDADE
    public function buscarAula($modalidade) {
        $stmt = $this->conn->prepare("SELECT * FROM aula WHERE modalidade = :modalidade");
        $stmt->execute([':modalidade' => $modalidade]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Aula(
                $row['id_aula'],
                $row['modalidade'],
                $row['data_hora']
            );
        }
        return null;
    }
}
?>