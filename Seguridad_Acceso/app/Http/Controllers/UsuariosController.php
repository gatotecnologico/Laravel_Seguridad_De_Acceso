<?php

namespace App\Http\Controllers;

use App\ModelosDominio\ManejadorDeUsuarios;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    public function registrarUsuario(Request $request)
    {
        $manejaUsuario = new ManejadorDeUsuarios();
        $correo = $request->input('email');
        $nip = $request->input('password');
        $respuesta = $manejaUsuario->registrarUsuario($correo, $nip);
        if ($respuesta === false) {
            return redirect()->route('login')->with('success', 'Usuario creado con éxito');
        } else {
            return back()->with('error', 'Ya existe un usuario con ese correo');
        }
    }

    public function logIn(Request $request)
    {
        $correo = $request->input('email');
        $nip = $request->input('password');
        $manejaUsuario = new ManejadorDeUsuarios();

        $respuesta = $manejaUsuario->login($correo, $nip);

        if ($respuesta === 'Error') {
            return back()->with('error', 'Ocurrio un error al iniciar sesion');
        }
        if ($respuesta === 'Bloqueado') {
            return back()->with('error', 'Aun no pasa el tiempo del bloqueo');
        }
        if ($respuesta === 'SobrepasaIntentos') {
            return back()->with('error', 'Sobrepasaste la cantidad de intentos');
        }
        if ($respuesta === 'Exito') {
            return view('usuario', ['usuarioModelo' => $respuesta]);
        }
    }

    public function logOut(Request $request)
    {
        $correo = $request->input('email');
        $manejaUsuario = new ManejadorDeUsuarios();
        $respuesta = $manejaUsuario->logOut($correo);
        if ($respuesta === true) {
            return redirect()->route('login')->with('success', 'Sesión cerrada exitosamente');
        }
        return back()->with('error', 'Error al cerrar sesión');
    }

    public function indexUsuario($correo)
    {
        $manejaUsuario = new ManejadorDeUsuarios();
        $usuarioModelo = $manejaUsuario->getIndexCorreo($correo);
        if($usuarioModelo === null) {
            return back()->with('error', 'Ocurrio un error al iniciar sesion');
        }
        return view('usuario', ['usuarioModelo' => $usuarioModelo]);
    }
}
