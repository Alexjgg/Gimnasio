<?php
namespace Com\Daw2\Helpers;

class Ejercicio
{
    private $idEjercicio;
    private $nombre;
    private $repeticiones;
    private $duracion;
    private $descripcion;

    public function __construct($idEjercicio, $nombre, $descripcion, $repeticiones, $duracion)
    {
        $this->idEjercicio = $idEjercicio;
        $this->nombre = $nombre;
        $this->repeticiones = $repeticiones;
        $this->duracion = $duracion;
        $this->descripcion = $descripcion;
    }

    public function getIdEjercicio()
    {
        return $this->idEjercicio;
    }

    public function setIdEjercicio($idEjercicio): self
    {
        $this->idEjercicio = $idEjercicio;
        return $this;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getDuracion()
    {
        return $this->duracion;
    }

    public function setDuracion($duracion): self
    {
        $this->duracion = $duracion;
        return $this;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion): self
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    public function getRepeticiones()
    {
        return $this->repeticiones;
    }

    public function setRepeticiones($repeticiones): self
    {
        $this->repeticiones = $repeticiones;
        return $this;
    }
}