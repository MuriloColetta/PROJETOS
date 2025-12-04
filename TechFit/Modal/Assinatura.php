<?php 
class Assinatura {
    private $id_assinatura;
    private $id_cliente;
    private $id_plano;

    public function __construct($id_assinatura, $id_cliente, $id_plano) {
        $this->id_assinatura = $id_assinatura;
        $this->id_cliente = $id_cliente;
        $this->id_plano = $id_plano;
    }

    public function getIdCliente() {
        return $this->id_cliente;
    }

    public function setIdCliente($id_cliente): self  {
        $this->id_cliente = $id_cliente;
        return $this;
    }

    public function getIdPlano() {
        return $this->id_plano;
    }

    public function setIdPlano($id_plano): self {
        $this->id_plano = $id_plano;
        return $this;
    }
}

?>