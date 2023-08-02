<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Empresas/Index', ['empresas' => Empresa::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Empresas/RegistrarEmpresa');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'nombre' => 'required',
        ]);
        if($validator->fails()){
            return back()->withErrors(['validacion' => 'Ha ocurrido un error '.$validator->errors()]);
        }
        $empresa = new Empresa;
        $empresa->nombre = $input['nombre'];
        $empresa->save();
        return redirect()->route('empresas.index')->with('message', 'Empresa Registrada con Éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Empresa $empresa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empresa $empresa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empresa $empresa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empresa $empresa)
    {
        if(!$empresa) return back()->withErrors(['validacion' => 'Esta empresa no existe']);
        if($empresa->id == Auth::user()->empresa) return back()->withErrors(['validacion' => 'No puede eliminar su propia empresa']);
        $empresa->delete();
        return redirect()->route('empresas.index')->with('message', 'Empresa Eliminada con Éxito');
    }
}
