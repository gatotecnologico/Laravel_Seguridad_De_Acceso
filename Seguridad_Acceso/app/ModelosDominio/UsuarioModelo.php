<?php

namespace App\ModelosDominio;

use App\Database\ServiciosTecnicos;

class UsuarioModelo
{
    private string $correo;
    private string $nip;
    private int $cantidadIntentos;
    private bool $estado;
    private ServiciosTecnicos $serviciosTecnicos;

    public function __construct(string $correo, string $nip)
    {
        $this->correo = $correo;
        $this->nip = $nip;
        $this->cantidadIntentos = 0;
        $this->estado = false;
        $this->serviciosTecnicos = new ServiciosTecnicos();
    }

    public function registrarUsuario()
    {
        $existe = $this->serviciosTecnicos->buscarCorreo($this->correo);
        if ($existe === null) {
            $this->serviciosTecnicos->insertUsuario($this->correo, $this->nip);
            return false;
        } else {
            return true;
        }
    }

    public function login() {
        $usuarioExiste = $this->serviciosTecnicos->login($this->correo, $this->nip);
        $cantidadIntentos = $this->serviciosTecnicos->getCantidadIntentos($this->correo);
        if ($usuarioExiste != null && ($cantidadIntentos < 3)) {
            $this->estado = true;
            $this->serviciosTecnicos->actualizarEstado($this->correo, $this->estado);
            return 0;
        } else if ($cantidadIntentos >= 3) {
            return 1;
        }else if ($usuarioExiste === null) {
            return 2;
        }
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
}
