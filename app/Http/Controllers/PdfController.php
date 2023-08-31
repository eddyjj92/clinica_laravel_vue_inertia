<?php

namespace App\Http\Controllers;

use App\Models\Cuestionario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function stream(Cuestionario $cuestionario)
    {
        $fecha = new \DateTime();

        $data = [
            'data' => $cuestionario->data,
            'fecha' => $fecha->format('d/m/Y H:i:s')
        ];
        try{
            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            return PDF::loadView('pdf', $data)->setPaper('letter')
                ->stream('archivo.pdf');
        }catch (\Exception $e){
            dd($e);
            return redirect()->route('dashboard');
        }

    }
}
