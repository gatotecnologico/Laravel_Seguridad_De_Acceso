<?php

namespace App\Database;

use App\ModelosDominio\UsuarioModelo;
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
            return $usuario;
        } else {
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
}
