<?php

namespace App\Database;

use App\ModelosDominio\UsuarioModelo;
use Exception;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class ServiciosTecnicos
{
    public function insertUsuario(UsuarioModelo $usuarioModelo): void {
        $nuevoUsuario = new Usuario();
        $nuevoUsuario->correo = $usuarioModelo->getCorreo();
        $nuevoUsuario->nip = $usuarioModelo->getNip();
        $nuevoUsuario-> save();
    }

    public function buscarCorreo($correo):? Usuario {
        return Usuario::where('correo', $correo)->first();
    }
}
