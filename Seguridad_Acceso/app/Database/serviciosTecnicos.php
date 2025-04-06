<?php

namespace App\Database;

use App\ModelosDominio\UsuarioModelo;
use Exception;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class ServiciosTecnicos
{
    public function insertUsuario(UsuarioModelo $usuarioModelo): void {
        $nuevoUsuario = new Usuario();
        $nuevoUsuario->correo = $usuarioModelo->getCorreo();
        $nuevoUsuario->nip = Hash::make($usuarioModelo->getNip());
        $nuevoUsuario->save();
    }

    public function buscarCorreo($correo):? Usuario {
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
}
