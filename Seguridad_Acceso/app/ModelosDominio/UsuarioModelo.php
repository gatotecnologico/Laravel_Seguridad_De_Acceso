<?php

namespace App\ModelosDominio;

use App\Database\ServiciosTecnicos;
use DateTime;

class UsuarioModelo
{
    private string $correo;
    private string $nip;
    private int $cantidadIntentos;
    private bool $estado;
    private DateTime $fechaBloqueo;

    public function __construct(string $correo, string $nip)
    {
        $this->correo = $correo;
        $this->nip = $nip;
        $this->cantidadIntentos = 0;
        $this->estado = false;
        $this->fechaBloqueo = new DateTime();
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

    public function getCantidadIntentos(): int
    {
        return $this->cantidadIntentos;
    }

    public function setCantidadIntentos(int $cantidadIntentos): void
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

    public function getFechaBloqueo(): DateTime
    {
        return $this->fechaBloqueo;
    }

    public function setFechaBloqueo(DateTime $fechaBloqueo): void
    {
        $this->fechaBloqueo = $fechaBloqueo;
    }
}
