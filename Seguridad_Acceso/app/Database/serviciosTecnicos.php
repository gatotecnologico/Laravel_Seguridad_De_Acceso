<?php

namespace App\Database;

use App\ModelosDominio\UsuarioModelo;
use Exception;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;  // Add this import

class ServiciosTecnicos
{
    public function insertUsuario(UsuarioModelo $usuarioModelo): void {
        $nuevoUsuario = new Usuario();
        $nuevoUsuario->correo = $usuarioModelo->getCorreo();
        $nuevoUsuario->nip = Hash::make($usuarioModelo->getNip());  // Hash the password
        $nuevoUsuario->save();
    }

    public function buscarCorreo($correo):? Usuario {
        return Usuario::where('correo', $correo)->first();
    }
}
