<?php

namespace App\ModelosDominio;

use Ramsey\Uuid\Type\Integer;

class UsuarioModelo
{
    private string $correo;
    private string $nip;
    private Integer $cantidadIntentos;
    private bool $estado;

    public function __construct(string $correo, string $nip)
    {
        $this->correo = $correo;
        $this->nip = $nip;
    }

    public function getCorreo(): string
    {
        return $this->correo;
    }

    public function setCorreo(string $correo): void
    {
        $this->correo = $correo;
    }

    public function getNip(): string
    {
        return $this->nip;
    }

    public function setNip(string $nip): void
    {
        $this->nip = $nip;
    }

    public function getCantidadIntentos(): Integer
    {
        return $this->cantidadIntentos;
    }

    public function setCantidadIntentos(Integer $cantidadIntentos): void
    {
        $this->cantidadIntentos = $cantidadIntentos;
    }

    public function getEstado(): bool
    {
        return $this->estado;
    }

    public function setEstado(bool $estado): void
    {
        $this->estado = $estado;
    }
}
