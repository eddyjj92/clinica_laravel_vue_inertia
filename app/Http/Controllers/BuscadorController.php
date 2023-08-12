<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;

class BuscadorController extends Controller
{
    public function buscador(Request $request){
        $key = $request->get('key');
        return response()->json([
            'users' => User::where('nombre','LIKE','%'.$key.'%')->get(),
            'empresas' => Empresa::where('nombre','LIKE','%'.$key.'%')->get(),
        ]);
    }
}
