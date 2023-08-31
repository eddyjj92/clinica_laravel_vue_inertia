<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $solicitudes = Solicitud::all();
        foreach ($solicitudes as $solicitud){
            $solicitud->user;
        }
        return Inertia::render('Solicitudes/Index', [
            'solicitudes' => $solicitudes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Solicitudes/Registrar', ['usuarios' => User::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'usuario' => 'required',
            'trabajadores' => 'required',
        ]);
        if($validator->fails()){
            return back()->withErrors(['validacion' => 'Ha ocurrido un error '.$validator->errors()]);
        }
        $sol = new Solicitud();
        $sol->usuario_id = $input['usuario'];
        $sol->trabajadores = $input['trabajadores'];
        $sol->save();
        for($i = 0; $i < (int) $sol->trabajadores; $i++){
            $voucher = new Voucher();
            $voucher->voucher = uniqid('lcp');
            $voucher->estado = 1;
            $voucher->solicitude_id = $sol->id;
            $voucher->save();
        }
        return redirect()->route('solicitudes.index')->with('message', 'Solicitud Registrada con Éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Solicitud $solicitude)
    {
        $solicitude->user;
        $solicitude->vouchers;
        return Inertia::render('Solicitudes/Ver', ['solicitud' => $solicitude]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Solicitud $solicitud)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Solicitud $solicitud)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Solicitud $solicitude)
    {
        $solicitude->delete();
        return redirect()->route('solicitudes.index')->with('message', 'Solicitud Eliminada con Éxito');
    }
}
