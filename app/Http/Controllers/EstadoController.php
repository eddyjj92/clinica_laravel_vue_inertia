<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EstadoController extends Controller
{
    public function estado5910()
    {
        $estado = new ConexionController('educacion', 'sa', 'Versat1*');
        $apertura = $estado->saldosApertura(11);
        $actual = $estado->saldosFechaActual(9);
        $pln = $estado->saldosPln(11);
        return response()->json(['success' => true, 'apertura' => $apertura, 'actual' => $actual, 'pln' => $pln]);
    }
}
