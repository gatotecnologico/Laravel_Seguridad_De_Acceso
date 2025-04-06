<?php

namespace App\Http\Controllers;

use App\Database\ServiciosTecnicos;
use App\ModelosDominio\UsuarioModelo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    private static UsuarioModelo $usuario;
    private static ServiciosTecnicos $serviciosTecnicos;
    public function __construct() {
        if(self::$serviciosTecnicos === null){
            self::$serviciosTecnicos = new serviciosTecnicos();
        }
    }

    public function registrarUsuario(Request $request) {
        $correo = $request->input('email');
        $contra = $request->input('password');
        $usuarioModelo = new UsuarioModelo($correo, $contra);

        $existe = $usuarioModelo->existeCorreo($this->serviciosTecnicos, $correo);
        if ($existe === false) {
            $this->serviciosTecnicos->insertUsuario($usuarioModelo);
        } else if ($existe === true) {
            return 'Ya existe un usuario con ese correo';
        }
    }
}
