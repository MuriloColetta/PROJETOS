<?php 
class Aula {
    private $modalidade;
    private $data_hora;

    public function __construct($modalidade, $data_hora) {
        $this->modalidade = $modalidade;
        $this->data_hora = $data_hora;
    }

    public function getModalidade() {
        return $this->modalidade;
    }

    public function setModalidade($modalidade): self  {
        $this->modalidade = $modalidade;
        return $this;
    }

    public function getDataHora() {
        return $this->data_hora;
    }

    public function setDataHora($data_hora): self {
        $this->data_hora = $data_hora;
        return $this;
    }
}

?>