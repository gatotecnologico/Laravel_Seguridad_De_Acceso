<?php

namespace App\Http\Controllers;

use App\Database\ServiciosTecnicos;
use App\ModelosDominio\UsuarioModelo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    private ServiciosTecnicos $serviciosTecnicos;
    public function __construct()
    {
        $this->serviciosTecnicos = new serviciosTecnicos();
    }

    public function registrarUsuario(Request $request) {
        $correo = $request->input('email');
        $contra = $request->input('password');
        $usuarioModelo = new UsuarioModelo($correo, $contra);
    
        $existe = $usuarioModelo->existeCorreo($this->serviciosTecnicos, $correo);
        if ($existe === false) {
            $this->serviciosTecnicos->insertUsuario($usuarioModelo);
            return redirect()->route('login')->with('success', 'Usuario creado con éxito');
        } else if ($existe === true) {
            return back()->with('error', 'Ya existe un usuario con ese correo');
        }
    }
}
