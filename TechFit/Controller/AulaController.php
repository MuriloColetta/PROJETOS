<?php
require_once __DIR__ . '/../Model/AulaDAO.php';
require_once __DIR__ . '/../Model/Aula.php';

class AulaController {
    private $dao;

    // Contrutor: cria o objeto DAO (responsável por salvar/carregar)
    public function __construct() {
        $this->dao = new AulaDAO();
    }

    // Lista todas as aulas
    public function ler() {
        return $this->dao->lerAula();
    }

    // Cadastra nova aula
    public function criar($modalidade, $data_hora) {

        // // Gera ID automaticamente com base no timestamp (exemplo simples)
        // $id = time(); // Função caso o objeto tenha um atributo de ID

        $aula = new Aula( null, $modalidade, $data_hora);
        $this->dao->criarAula($aula);
    }

    // Atualiza aula existente
    public function atualizar( $modalidade, $novaModalidade, $data_hora) {
        $this->dao->atualizarAula( $modalidade, $novaModalidade, $data_hora);
    }

    // Exclui aula
    public function deletar($modalidade) {
        $this->dao->deletarAula($modalidade);
    }

    // Buscar aula por modalidade
    public function buscar( $modalidade ) {
        return $this->dao->buscarAula( $modalidade );
    }
}
?>