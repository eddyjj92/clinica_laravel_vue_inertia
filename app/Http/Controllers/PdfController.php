<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function stream()
    {
        $data = [
            'titulo' => 'Styde.net'
        ];

        return PDF::loadView('pdf', $data)->setPaper('letter')
            ->stream('archivo.pdf');
    }
}
