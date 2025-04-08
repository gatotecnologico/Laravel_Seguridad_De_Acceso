<?php

namespace App\Database;

use Exception;
use App\Models\Usuario;
use App\ModelosDominio\UsuarioModelo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class ServiciosTecnicos
{
    private $fechaBloqueo;
    public function insertUsuario(UsuarioModelo $usuarioModelo): void
    {
        $nuevoUsuario = new Usuario();
        $nuevoUsuario->correo = $usuarioModelo->getCorreo();
        $nuevoUsuario->nip = Hash::make($usuarioModelo->getNip());
        $nuevoUsuario->save();
    }

    public function buscarUsuarioCorreo($correo): ?UsuarioModelo
    {
        $usuario = Usuario::where('correo', $correo)->first();
        $usuarioModelo = new UsuarioModelo($usuario->correo, $usuario->nip);
        $usuarioModelo->setCantidadIntentos($usuario->cantidadIntentos);
        $usuarioModelo->setEstado($usuario->estado);
        return $usuarioModelo;
    }

    public function login(UsuarioModelo $usuarioModelo)
    {
        $usuario = Usuario::where('correo', $usuarioModelo->getCorreo())->first();
        // dd($usuario);
        if ($usuario->correo === null) {
            return null;
        }

        if (Hash::check($usuarioModelo->getNip(), $usuario->nip) && ($usuarioModelo->getEstado() != 1)) {
            // $diferenciaEnMinutos += 30;
            $usuario->cantidad_intentos = 0;
            $usuario->save();
        }
        return $usuarioModelo;
        // else {
        //     $usuario->cantidad_intentos += 1;
        //     if ($usuario->cantidad_intentos == 3) {
        //         $this->fechaBloqueo = Carbon::now();
        //         // $usuario->save();
        //     }
        //     $usuario->save();
        //     return 'Error';
        // }
    }

    public function actualizarEstado(UsuarioModelo $usuarioModelo)
    {
        $usuario = Usuario::where('correo', $usuarioModelo->getCorreo())->first();
        if ($usuario) {
            $usuario->estado = $usuarioModelo->getEstado();
            $usuario->save();
        }
    }

    public function actualizarCantIntentos(UsuarioModelo $usuarioModelo)
    {
        $usuario = Usuario::where('correo', $usuarioModelo->getCorreo())->first();
        if ($usuario) {
            $usuario->cantidadIntentos + 1;
            if ($usuario->cantidad_intentos === 3) {
                $this->fechaBloqueo = Carbon::now();
            }
            $usuario->save();
        }
    }

    public function validarBloqueoMinutos(UsuarioModelo $usuarioModelo) {
        if ($usuarioModelo->getCantidadIntentos() === 3) {
            $ahora = Carbon::now();
            $diferenciaEnMinutos = $ahora->diffInMinutes(Carbon::parse($this->fechaBloqueo));
            if ($diferenciaEnMinutos <= 30) {
                return false;
            }
        }
        return true;
    }

    public function getCantidadIntentos($correo): int
    {
        $usuario = Usuario::where('correo', $correo)->first();
        return $usuario->cantidad_intentos;
    }
}
