<?php 
class Aula {
    private $id_aula;
    private $modalidade;
    private $data_hora;

    public function __construct($id_aula, $modalidade, $data_hora) {
        $this->id_aula = $id_aula;
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