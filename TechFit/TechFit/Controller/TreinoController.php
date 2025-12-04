<?php
require_once __DIR__ . '/../Modal/TreinoDAO.php';
require_once __DIR__ . '/../Modal/Treino.php';

class TreinoController {
    private $dao;

    // Construtor: cria o objeto DAO (responsável por salvar/carregar)
    public function __construct() {
        $this->dao = new TreinoDAO();
    }

    // Lista todos os treinos
    public function ler() {
        return $this->dao->lerTreino();
    }

    // Cadastra novo treino
    public function criar($nome_treino, $descricao, $dias) {

        // // Gera ID automaticamente com base no timestamp (exemplo simples)
        // $id = time(); // Função caso o objeto tenha um atributo de ID

        $treino = new Treino( null, $nome_treino, $descricao, $dias);
        $this->dao->criarTreino($treino);
    }

    // Atualiza treino existente
    public function atualizar($nome_treino, $novoNome_treino, $descricao, $dias) {
        $this->dao->atualizarTreino($nome_treino, $novoNome_treino, $descricao, $dias);
    }

    // Exclui treino
    public function deletar($nome_treino) {
        $this->dao->deletarTreino($nome_treino);
    }

    // Busca treino por nome
    public function buscar($nome_treino) {
        return $this->dao->buscarTreino($nome_treino);
    }
}

?>