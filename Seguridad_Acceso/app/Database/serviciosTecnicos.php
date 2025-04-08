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
        if (!$usuario) {
            return null;
        }
        $usuarioModelo = new UsuarioModelo($usuario->correo, $usuario->nip);
        $usuarioModelo->setCantidadIntentos($usuario->cantidadIntentos ?? 0); // Set default value to 0
        $usuarioModelo->setEstado($usuario->estado ?? 0); // Set default value to 0
        return $usuarioModelo;
    }

    public function login(UsuarioModelo $usuarioModelo)
    {
        $usuario = Usuario::where('correo', $usuarioModelo->getCorreo())->first();
        if (!$usuario) {
            return null;
        }
        $usuarioModelo->setEstado($usuario->estado);
        if (!Hash::check($usuarioModelo->getNip(), $usuario->nip)) {
            $this->actualizarCantIntentos($usuarioModelo);
            return null;
        }
        if (Hash::check($usuarioModelo->getNip(), $usuario->nip) && ($usuarioModelo->getEstado() != 1)) {
            if($this->validarBloqueoMinutos($usuarioModelo) === false) {
                return 'Bloqueado';
            }
            $usuario->cantidadIntentos = 0;
            $usuario->save();
        }
        return $usuarioModelo;
    }

    public function actualizarEstado(UsuarioModelo $usuarioModelo)
    {
        $usuario = Usuario::where('correo', $usuarioModelo->getCorreo())->first();
        if ($usuario) {
            $usuario->estado = $usuarioModelo->getEstado();
            $usuario->save();
        }
    }


    public function obtenerEstadoActual(UsuarioModelo $usuarioModelo)
    {
        $usuario = Usuario::where('correo', $usuarioModelo->getCorreo())->first();
        return $usuario->estado;
    }

    public function actualizarCantIntentos(UsuarioModelo $usuarioModelo)
    {
        $usuario = Usuario::where('correo', $usuarioModelo->getCorreo())->first();
        if ($usuario) {
            $usuario->cantidadIntentos = ($usuario->cantidadIntentos ?? 0) + 1; // Fix increment logic
            if ($usuario->cantidadIntentos === 3) {
                $this->fechaBloqueo = Carbon::now();
            }
            $usuario->save();
        }
    }

    public function validarBloqueoMinutos(UsuarioModelo $usuarioModelo) {
        $validaUsuario = $this->buscarUsuarioCorreo($usuarioModelo->getCorreo());
        if ($validaUsuario->getCantidadIntentos() >= 3) {
            $ahora = Carbon::now();
            $diferenciaEnMinutos = $ahora->diffInMinutes(Carbon::parse($this->fechaBloqueo));
            // $diferenciaEnMinutos += 30;
            if ($diferenciaEnMinutos <= 30) {
                return false;
            }
        }
        return true;
    }

    public function getCantidadIntentos($correo): int
    {
        $usuario = Usuario::where('correo', $correo)->first();
        return $usuario->cantidadIntentos;
    }
}
