<?php

namespace App\Modelos;

class UsuarioModelo
{
    private string $correo = '';

    public function __construct(string $correo = '')
    {
        $this->correo = $correo;
    }

    // Getter y Setter si es necesario
    public function getCorreo(): string
    {
        return $this->correo;
    }

    public function setCorreo(string $correo): void
    {
        $this->correo = $correo;
    }

}
