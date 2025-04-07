<?php

namespace App\Database;

use Exception;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class ServiciosTecnicos
{
    private $fechaBloqueo;
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
        $ahora = Carbon::now();
        $diferenciaEnMinutos = $ahora->diffInMinutes(Carbon::parse($this->fechaBloqueo));
        if ($usuario && Hash::check($nip, $usuario->nip) && ($usuario->estado != 1)) {
            $diferenciaEnMinutos += 30;
            if ($diferenciaEnMinutos <= 30) {
                return 'Bloqueado';
            }
            $usuario->cantidad_intentos = 0;
            $usuario->save();
            return 'Exito';
        } else {
            $usuario->cantidad_intentos += 1;
            if ($usuario->cantidad_intentos == 3) {
                $this->fechaBloqueo = Carbon::now();
                $usuario->save();
            }
            $usuario->save();
            return 'Error';
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

    public function getCantidadIntentos($correo): int
    {
        $usuario = Usuario::where('correo', $correo)->first();
        return $usuario->cantidad_intentos;
    }
}
