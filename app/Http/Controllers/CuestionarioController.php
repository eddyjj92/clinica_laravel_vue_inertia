<?php

namespace App\Http\Controllers;

use App\Models\Cuestionario;
use App\Models\Empresa;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CuestionarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->can('ver-cuestionario')){
            $cuestionarios =  Cuestionario::all();
        }else{
            $cuestionarios = [];
            $solicitudes = Auth::user()->solicituds;
            foreach ($solicitudes as $solicitude){
                $vouchers = $solicitude->vouchers;
                foreach($vouchers as $voucher){
                    if($voucher->cuestionario){
                        array_push($cuestionarios,$voucher->cuestionario);
                    }
                }
            }
        }
        return Inertia::render('Cuestionarios/Index', ['cuestionarios' => $cuestionarios]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if(!session('voucher')){
            $input = $request->all();
            $validator = Validator::make($input, [
                'voucher' => 'required',
            ]);
            if($validator->fails()){
                return back()->withErrors(['validacion' => 'Ha ocurrido un error '.$validator->errors()]);
            }
            $voucher = Voucher::where('voucher', $input['voucher'])->first();
            if(!$voucher) return back()->withErrors(['validacion' => 'El voucher ingresado no es válido']);
            session(['voucher' => $voucher->id]);
            $voucher->estado = 2;
            $voucher->save();
        }
        return Inertia::render('Cuestionario', ['empresas' => Empresa::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $cuestionario = new Cuestionario();
        $cuestionario->paciente = $input['datos_generales']['nombre'];
        if($request->file('avatar')){
            try {
                $file = $filename = $input['datos_generales']['nombre'].".".$request->avatar->extension();
                $request->avatar->move(public_path("img/pacientes"), $filename);
                $input['datos_generales']['avatar'] = $file;
            }catch (\Exception $e){
                return back()->withErrors(['validacion' => $e->getMessage()]);
            }
        }else{
            $input['datos_generales']['avatar'] = 'user.png';
        }

        $cuestionario->data = $input;
        $cuestionario->estado = 1;
        $voucher = Voucher::find(session('voucher'));
        $cuestionario->voucher_id = $voucher->id;
        $cuestionario->save();
        $voucher->estado = 3;
        $voucher->save();
        session()->remove('voucher');
        return redirect()->route('login')->with('message', 'Los datos del cuestionarios han sido registrados de forma satisfactoria');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cuestionario $cuestionario)
    {
        return Inertia::render('Cuestionarios/Ver', [
            'cuestionario' => $cuestionario,
            'empresas' => Empresa::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cuestionario $cuestionario)
    {
        return Inertia::render('Cuestionarios/Editar', [
            'cuestionario' => $cuestionario,
            'empresas' => Empresa::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cuestionario $cuestionario)
    {
        $cuestionario->data = $request->all();
        $cuestionario->save();
        return response()->json(['message' => 'Cambios Guardados']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cuestionario $cuestionario)
    {
        $cuestionario->delete();
        return redirect()->route('cuestionarios.index')->with('message', 'El cuestionario ha sido eliminado de forma satisfactoria');
    }
}
