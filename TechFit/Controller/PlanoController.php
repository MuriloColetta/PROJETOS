<?php
require_once __DIR__ . '/../Model/PlanoDAO.php';
require_once __DIR__ . '/../Model/Plano.php';

class PlanoController {
    private $dao;

    // Contrutor: cria o objeto DAO (responsável por salvar/carregar)
    public function __construct() {
        $this->dao = new PlanoDAO();
    }

    // Lista todas os planos
    public function ler() {
        return $this->dao->lerPlano();
    }

    // Cadastra novo plano
    public function criar($nome_plano, $preco, $descricao) {

        // // Gera ID automaticamente com base no timestamp (exemplo simples)
        // $id = time(); // Função caso o objeto tenha um atributo de ID

        $plano = new Plano( null, $nome_plano, $preco, $descricao);
        $this->dao->criarPlano($plano);
    }

    // Atualiza plano existente
    public function atualizar( $nome_plano, $novoNome_plano, $preco, $descricao) {
        $this->dao->atualizarPlano( $nome_plano, $novoNome_plano, $preco, $descricao);
    }

    // Exclui plano
    public function deletar($nome_plano) {
        $this->dao->deletarPlano($nome_plano);
    }

    // Buscar plano por nome
    public function buscar( $nome_plano ) {
        return $this->dao->buscarPlano( $nome_plano );
    }
}
?>