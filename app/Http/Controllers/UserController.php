<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Usuarios/Index', ['usuarios' => User::all()]);
    }

    /**
     * Create a new resource.
     */
    public function create()
    {
        return Inertia::render('Usuarios/Registrar', ['empresas' => Empresa::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'correo' => 'required|email',
            'nombre' => 'required',
            'empresa' => 'required',
            'cargo' => 'required',
            'password' => 'required',
            'confirmar_password' => 'required|same:password',
        ]);
        if($validator->fails()){
            return back()->withErrors(['validacion' => 'Ha ocurrido un error '.$validator->errors()]);
        }
        $user = new User;
        $user->email = $input['correo'];
        $user->nombre = $input['nombre'];
        $user->empresa = $input['empresa'];
        $user->cargo = $input['cargo'];
        $user->password = bcrypt($input['password']);
        if($request->file('avatar')){
            try {
                $file = $filename = time().".".$request->avatar->extension();
                $request->avatar->move(public_path("img/profile"), $filename);
                $user->avatar = $file;
            }catch (\Exception $e){
                return back()->withErrors(['validacion' => $e->getMessage()]);
            }
        }else{
            $user->avatar = 'user.png';
        }
        $user->save();
        return redirect()->route('listar_usuarios')->with('message', 'Usuario Registrado con Éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
       return $user ? response()->json(['success' => true, 'user' => $user]) : response()->json(['success' => false, 'message' => 'Este usuario no existe'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return $user ? response()->json(['success' => true, 'user' => $user]) : response()->json(['success' => false, 'message' => 'Este usuario no existe'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $input = $request->all();
        $validator = Validator::make($input['body'], [
            'correo' => 'required|email',
            'nombre' => 'required',
            'empresa' => 'required',
            'cargo' => 'required',
            'password' => 'required',
            'verificar_password' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => json_decode($validator->errors())], 400);
        }
        $user->correo = $input['body']['correo'];
        $user->nombre = $input['body']['nombre'];
        $user->entidad = $input['body']['entidad'];
        $user->cargo = $input['body']['cargo'];
        $user->password = bcrypt($input['body']['correo']);
        $user->save();
        return response()->json(['success' => true, 'message' => 'Usuario registrado con éxito']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if(!$user) return back()->withErrors(['validacion' => 'Este usuario no existe']);
        if($user->id == Auth::user()->id) return back()->withErrors(['validacion' => 'No puede eliminar su propio usuario']);
        $user->delete();
        return redirect()->route('listar_usuarios')->with('message', 'Usuario Eliminado con Éxito');
    }
}
