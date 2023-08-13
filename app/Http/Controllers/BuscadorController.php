<?php

namespace App\Http\Controllers;

use App\Models\Cuestionario;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;

class BuscadorController extends Controller
{
    public function buscador($key){
        return response()->json([
            'usuarios' => User::where('nombre','LIKE','%'.$key.'%')->get(),
            'empresas' => Empresa::where('nombre','LIKE','%'.$key.'%')->get(),
            'cuestionarios' => Cuestionario::where('paciente','LIKE','%'.$key.'%')->get(),
        ]);
    }
}
