<?php
require_once __DIR__ . '/../Modal/AvaliacaoDAO.php';
require_once __DIR__ . '/../Modal/Avaliacao.php';

class AvaliacaoController {
    private $dao;

    // Contrutor: cria o objeto DAO (responsável por salvar/carregar)
    public function __construct() {
        $this->dao = new AvaliacaoDAO();
    }

    // Lista todas as avaliacoes
    public function ler() {
        return $this->dao->lerAvaliacao();
    }

    // Cadastra nova avaliacao
    public function criar($id_usuario, $id_funcionario, $peso_cliente, $altura_cliente, $data_avaliacao, $descricao) {

        // // Gera ID automaticamente com base no timestamp (exemplo simples)
        // $id = time(); // Função caso o objeto tenha um atributo de ID

        $avaliacao = new Avaliacao( null, $id_usuario, $id_funcionario,$peso_cliente, $altura_cliente, $data_avaliacao, $descricao);
        $this->dao->criarAvaliacao($avaliacao);
    }

    // Atualiza avaliacao existente
    public function atualizar( $id_avaliacao, $id_usuario, $id_funcionario, $peso_cliente, $altura_cliente, $data_avaliacao, $descricao) {
        $this->dao->atualizarAvaliacao( $id_avaliacao, $id_usuario, $id_funcionario, $peso_cliente, $altura_cliente, $data_avaliacao, $descricao);
    }

    // Exclui avaliacao
    public function deletar($id_avaliacao) {
        $this->dao->deletarAvaliacao($id_avaliacao);
    }

    // Buscar avaliacao por Id Cliente
    public function buscar( $id_cliente ) {
        return $this->dao->buscarAvaliacao( $id_cliente );
    }
}

?>