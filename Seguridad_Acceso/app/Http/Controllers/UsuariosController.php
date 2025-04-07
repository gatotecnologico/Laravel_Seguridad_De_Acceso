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
        $existe = $usuarioModelo->registrarUsuario();
        if ($existe === false) {
            return redirect()->route('login')->with('success', 'Usuario creado con éxito');
        } else {
            return back()->with('error', 'Ya existe un usuario con ese correo');
        }
    }

    public function logIn(Request $request) {
        $correo = $request->input('email');
        $contra = $request->input('password');
        $usuarioModelo = new UsuarioModelo($correo, $contra);

        $usuarioExiste = $this->serviciosTecnicos->login($correo, $contra);
        if ($usuarioExiste != null) {
            return view('usuario', ['usuario'=>$usuarioModelo]);
        } else if ($usuarioExiste === null) {
            return back()->with('error', 'Contraseña o correo invalido');
        }
    }

    public function indexUsuario($correo)
    {
        $usuarioModelo = $this->serviciosTecnicos->buscarCorreo($correo);
        return view('usuario', ['usuario'=>$usuarioModelo]);
    }
}
