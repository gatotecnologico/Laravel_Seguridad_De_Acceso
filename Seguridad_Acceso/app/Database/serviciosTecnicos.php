<?php

namespace App\Database;

use Exception;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class ServiciosTecnicos
{
    public function insertUsuario($correo, $nip): void
    {
        $nuevoUsuario = new Usuario();
        $nuevoUsuario->correo = $correo;
        $nuevoUsuario->nip = Hash::make($nip);
        $nuevoUsuario->save();
    }

    public function buscarCorreo($correo): ?Usuario
    {
        return Usuario::where('correo', $correo)->first();
    }

    public function login($correo, $nip)
    {
        $usuario = Usuario::where('correo', $correo)->first();
        if ($usuario && Hash::check($nip, $usuario->nip)) {
            $usuario->cantidad_intentos = 0;
            $usuario->save();
            return $usuario;
        } else {
            $usuario->cantidad_intentos += 1;
            $usuario->save();
            return null;
        }
    }

    public function actualizarEstado($correo, $estado)
    {
        $usuario = Usuario::where('correo', $correo)->first();
        if ($usuario) {
            $usuario->estado = $estado;
            $usuario->save();
            return true;
        }
        return false;
    }

    public function getCantidadIntentos($correo): int
    {
        $usuario = Usuario::where('correo', $correo)->first();
        return $usuario->cantidad_intentos;
    }
}
