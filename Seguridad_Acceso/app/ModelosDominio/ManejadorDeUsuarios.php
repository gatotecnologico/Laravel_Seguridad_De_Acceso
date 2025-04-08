<?php

namespace App\ModelosDominio;

use App\Database\ServiciosTecnicos;

class ManejadorDeUsuarios
{
    public function registrarUsuario($correo, $nip)
    {
        $serviciosTecnicos = new ServiciosTecnicos();
        $usuario = $serviciosTecnicos->buscarUsuarioCorreo($correo);
        if ($usuario === null) {
            $serviciosTecnicos->insertUsuario($correo, $nip);
            return false;
        } else {
            return true;
        }
    }

    public function login($correo, $nip) {
        $serviciosTecnicos = new ServiciosTecnicos();
        $credenciales = new UsuarioModelo($correo, $nip);
        $usuarioModelo = $serviciosTecnicos->login($credenciales);
        // $usuarioModelo->setCantidadIntentos($usuario->cantidadIntentos);
        // $usuarioModelo->setEstado($usuario->estado);
        if($usuarioModelo === null) {
            return 'Error';
        }
        if($usuarioModelo->getCantidadIntentos() >= 3) {
            return 'SobrepasaIntentos';
        }
        if($usuarioModelo->getEstado() === 1) {
            $serviciosTecnicos->actualizarCantIntentos($usuarioModelo);
            return 'Error';
        }if($serviciosTecnicos->validarBloqueoMinutos($usuarioModelo) === false) {
            return 'Bloqueado';
        }
        $usuarioModelo->setEstado(true);
        $serviciosTecnicos->actualizarEstado($usuarioModelo);
        return 'Exito';
    }

    public function logOut($correo) {
        $serviciosTecnicos = new ServiciosTecnicos();
        $usuarioModelo = $serviciosTecnicos->buscarUsuarioCorreo($correo);
        $serviciosTecnicos->actualizarEstado($usuarioModelo);
        return true;
    }

    public function getIndexCorreo($correo) {
        $serviciosTecnicos = new ServiciosTecnicos();
        $usuarioModelo = $serviciosTecnicos->buscarUsuarioCorreo($correo);
        return $usuarioModelo;
    }
}
