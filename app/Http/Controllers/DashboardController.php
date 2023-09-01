<?php

namespace App\Http\Controllers;

use App\Models\Cuestionario;
use App\Models\Solicitud;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        $contConectados = 0;
        $contDesconectados = 0;
        $contNoAuth = 0;
        foreach ($users as $user){
          $estado = ConexionController::verificaConexionUsuario($user);
          $estado === 'conectado' ? $contConectados++ : null;
          $estado === 'desconectado' ? $contDesconectados++ : null;
          $estado === 'sin autenticar' ? $contNoAuth++ : null;
        }
        $solicitudes = Auth::user()->can('ver-solicitud') ? Solicitud::where('estado', 1)->get() : Solicitud::where('estado', 1)->where('user_id', Auth::user()->getAuthIdentifier())->get();
        foreach ($solicitudes as $solicitude) {
            $solicitude->user->empresa;
            $solicitude->vouchers;
        }

        if(Auth::user()->can('ver-cuestionario')){
            $cuestionarios =  Cuestionario::where('estado', 1)->get();
        }else{
            $cuestionarios = [];
            $sols = Auth::user()->solicituds;
            foreach ($sols as $sol){
                $vouchers = $sol->vouchers;
                foreach($vouchers as $voucher){
                    if($voucher->cuestionario && $voucher->cuestionario->estado == 1){
                        array_push($cuestionarios,$voucher->cuestionario);
                    }
                }
            }
        }

        return Inertia::render('Dashboard', [
            'cantUsers' => count(User::all()),
            'conectados' => $contConectados,
            'desconectados' => $contDesconectados,
            'noAuth' => $contNoAuth,
            'cuest' => count(Voucher::where('estado', 2)->get()),
            'solicitudes' => $solicitudes,
            'solProceso' => count($solicitudes),
            'solArchivada' => count(Auth::user()->can('ver-solicitud') ? Solicitud::where('estado', 2)->get() : Solicitud::where('estado', 2)->where('user_id', Auth::user()->getAuthIdentifier())->get()),
            'cuestionarios' => $cuestionarios,
            'cuestionariosAprob' => count(Cuestionario::where('estado', 2)->get()),
            'cuestionariosDen' => count(Cuestionario::where('estado', 0)->get()),
        ]);
    }
}
