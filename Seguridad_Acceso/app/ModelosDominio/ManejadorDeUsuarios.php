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
            $usuarioModelo = new UsuarioModelo($correo, $nip);
            $serviciosTecnicos->insertUsuario($usuarioModelo);
            return false;
        } else {
            return true;
        }
    }

    public function login($correo, $nip) {
        $serviciosTecnicos = new ServiciosTecnicos();
        $credenciales = new UsuarioModelo($correo, $nip);
        $usuarioModelo = $serviciosTecnicos->login($credenciales);
        if($usuarioModelo === null) {
            return 'Error';
        }
        if($usuarioModelo->getEstado() === true) {
            $serviciosTecnicos->actualizarCantIntentos($usuarioModelo);
            return 'Error';
        }
        if($usuarioModelo === 'Bloqueado') {
            return 'Bloqueado';
        }
        if($usuarioModelo->getCantidadIntentos() >= 3) {
            return 'SobrepasaIntentos';
        }
        $usuarioModelo->setEstado(true);
        $serviciosTecnicos->actualizarEstado($usuarioModelo);
        return 'Exito';
    }

    public function logOut($correo) {
        $serviciosTecnicos = new ServiciosTecnicos();
        $usuarioModelo = $serviciosTecnicos->buscarUsuarioCorreo($correo);
        $usuarioModelo->setEstado(false);
        $serviciosTecnicos->actualizarEstado($usuarioModelo);
        return true;
    }

    public function getIndexCorreo($correo) {
        $serviciosTecnicos = new ServiciosTecnicos();
        $usuarioModelo = $serviciosTecnicos->buscarUsuarioCorreo($correo);
        return $usuarioModelo;
    }
}
