<?php
require_once __DIR__ . '/../Model/AssinaturaDAO.php';
require_once __DIR__ . '/../Model/Assinatura.php';

class AssinaturaController {
    private $dao;

    // Contrutor: cria o objeto DAO (responsável por salvar/carregar)
    public function __construct() {
        $this->dao = new AssinaturaDAO();
    }

    // Lista todas as assinaturas
    public function ler() {
        return $this->dao->lerAssinatura();
    }

    // Cadastra nova assinatura
    public function criar($id_cliente, $id_plano) {

        // // Gera ID automaticamente com base no timestamp (exemplo simples)
        // $id = time(); // Função caso o objeto tenha um atributo de ID

        $assinatura = new Assinatura( null, $id_cliente, $id_plano);
        $this->dao->criarAssinatura($assinatura);
    }

    // Atualiza assinatura existente
    public function atualizar( $id_cliente, $novoId_cliente, $id_plano) {
        $this->dao->atualizarAssinatura( $id_cliente, $novoId_cliente, $id_plano);
    }

    // Exclui assinatura
    public function deletar($id_cliente) {
        $this->dao->deletarAssinatura($id_cliente);
    }

    // Buscar assinatura por id_cliente
    public function buscar( $id_cliente ) {
        return $this->dao->buscarAssinatura( $id_cliente );
    }
}
?>