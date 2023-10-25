<?php
namespace Com\Daw2\Helpers;

class Usuario
{
    private $nombre;
    private $rol;
    private $email;
    private $pass;
    public $idUsuario;

    public function __construct($nombre, $rol, $email, $pass, $idUsuario)
    {
        $this->nombre = $nombre;
        $this->rol = $rol;
        $this->email = $email;
        $this->pass = $pass;
        $this->idUsuario = $idUsuario;
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

    public function getRol()
    {
        return $this->rol;
    }

    public function setRol($rol): self
    {
        $this->rol = $rol;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPass()
    {
        return $this->pass;
    }

    public function setPass($pass): self
    {
        $this->pass = $pass;
        return $this;
    }

    public function getidUsuario()
    {
        return $this->idUsuario;
    }

    public function setidUsuario($idUsuario): self
    {
        $this->idUsuario = $idUsuario;
        return $this;
    }
}