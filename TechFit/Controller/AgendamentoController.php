<?php
require_once __DIR__ . '/../Modal/AgendamentoDAO.php';
require_once __DIR__ . '/../Modal/Agendamento.php';

class AgendamentoController {
    private $dao;

    // Contrutor: cria o objeto DAO (responsável por salvar/carregar)
    public function __construct() {
        $this->dao = new AgendamentoDAO();
    }

    // Lista todas os agendamentos
    public function ler() {
        return $this->dao->lerAgendamento();
    }

    // Cadastrar novo agendamento
    public function criar($status_agendamento, $id_cliente, $id_aula) {
        
        // // Gera ID automaticamente com base no timestamp (exemplo simples)
        // $id = time(); // Função caso o objeto tenha um atributo de ID

        $agendamento = new Agendamento(null,$status_agendamento, $id_cliente, $id_aula);
        $agendamento->setStatus($status_agendamento);
        $this->dao->criarAgendamento($agendamento);
    }

    // Atualizar agendamento existente
    public function atualizar($id_cliente, $novoId_cliente, $id_aula, $status_agendamento) {
        $this->dao->atualizarAgendamento($id_cliente, $novoId_cliente, $id_aula, $status_agendamento);
    }

    // Excluir agendamento
    public function deletar($id_cliente){
        $this->dao->deletarAgendamento($id_cliente);
    }

    // Buscar agendamento por id cliente
    public function buscar($id_cliente){
        $this->dao->buscarAgendamento($id_cliente);
    }
}
?>