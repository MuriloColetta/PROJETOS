<?php
class Agendamento {
    private $id_agendamento;
    private $status_agendamento;
    private $id_cliente;
    private $id_aula;

    public function __construct($id_agendamento, $status_agendamento,$id_cliente, $id_aula) {
        $this->id_agendamento = $id_agendamento;
        $this->status_agendamento = $status_agendamento;
        $this->id_cliente = $id_cliente;
        $this->id_aula = $id_aula;
    }

    public function getStatus() {
        return $this->status_agendamento;
    }

    public function setStatus($status_agendamento) {
        $this->status_agendamento = $status_agendamento;
        return $this;
    }

    public function getIdCliente() {
        return $this->id_cliente;
    }

    public function setIdCliente($id_cliente) {
        $this->id_cliente = $id_cliente;
        return $this;
    }

    public function getIdAula() {
        return $this->id_aula;
    }

    public function setIdAula($id_aula) {
        $this->id_aula = $id_aula;
        return $this;
    }
}

?>