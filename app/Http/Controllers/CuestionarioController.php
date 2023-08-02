<?php

namespace App\Http\Controllers;

use App\Models\Cuestionario;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CuestionarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Cuestionario', ['empresas' => Empresa::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cuestionario $cuestionario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cuestionario $cuestionario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cuestionario $cuestionario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cuestionario $cuestionario)
    {
        //
    }
}
