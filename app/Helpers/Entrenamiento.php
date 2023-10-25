<?php
namespace Com\Daw2\Helpers;

class Entrenamiento
{
    private $Nombre;
    private $idEntrenador;
    private $Dia;
    private $idEntrenamiento;
    public function __construct($Nombre, $Dia, $idEntrenador, $idEntrenamiento)
    {
        $this->idEntrenador = $idEntrenador;
        $this->Dia = $Dia;
        $this->Nombre = $Nombre;
        $this->idEntrenamiento = $idEntrenamiento;
    }


    public function getNombre()
    {
        return $this->Nombre;
    }

    public function setNombre($Nombre): self
    {
        $this->Nombre = $Nombre;
        return $this;
    }

    public function getIdEntrenador()
    {
        return $this->idEntrenador;
    }

    public function setIdEntrenador($idEntrenador): self
    {
        $this->idEntrenador = $idEntrenador;
        return $this;
    }

    public function getIdEntrenamiento()
    {
        return $this->idEntrenamiento;
    }

    public function setIdEntrenamiento($idEntrenamiento): self
    {
        $this->idEntrenador = $idEntrenamiento;
        return $this;
    }
    public function getDia()
    {
        return $this->Dia;
    }

    public function setDia($Dia): self
    {
        $this->Dia = $Dia;
        return $this;
    }
}