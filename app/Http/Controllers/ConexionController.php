<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConexionController extends Controller
{
    public static function conecta(User $user): void
    {
        $date = time();
        $ip = $_SERVER['REMOTE_ADDR'];
        $data = [
            'fecha' => $date,
            'ip' => $ip,
        ];
        $user->conexion = $data;
        $user->save();
    }

    public static function verificaConexionUsuario(User $user)
    {
        $time = 3;
        $date = time();
        $limite = $date - $time * 60;
        $conexion = $user->conexion;
        if (isset($conexion['fecha'])) {
            if ((int)$conexion['fecha'] > $limite) {
                return 'conectado';
            } else {
                return 'desconectado';
            }
        } else {
            return 'sin autenticar';
        }
    }
}
