<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Permiso;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        foreach ($users as $user){
            $user->roles;
        }
        return Inertia::render('Usuarios/Index', ['usuarios' => $users ]);
    }

    /**
     * Create a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        foreach ($roles as $role){
            $role->permissions->all();
        }
        return Inertia::render('Usuarios/Registrar', [
            'empresas' => Empresa::all(),
            'permisos' => Permission::all(),
            'roles' => $roles
        ]);
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
            'rol' => 'required'
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
                $file = $filename = $input['nombre'].".".$request->avatar->extension();
                $request->avatar->move(public_path("img/profile"), $filename);
                $user->avatar = $file;
            }catch (\Exception $e){
                return back()->withErrors(['validacion' => $e->getMessage()]);
            }
        }else{
            $user->avatar = 'user.png';
        }
        $user->save();
        $user->assignRole([$input['rol']->id]);
        return redirect()->route('listar_usuarios')->with('message', 'Usuario Registrado con Éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return Inertia::render('Usuarios/Perfil', ['usuario' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user->roles[0]->permissions->all();
        $roles = Role::all();
        foreach ($roles as $role) {
            $role->permissions->all();
        }

        return Inertia::render('Usuarios/Editar', [
            'empresas' => Empresa::all(),
            'permisos' => Permission::all(),
            'usuario' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'correo' => 'required|email',
            'nombre' => 'required',
            'empresa' => 'required',
            'cargo' => 'required',
            'rol' => 'required',
        ]);
        if($validator->fails()){
            return back()->withErrors(['validacion' => 'Ha ocurrido un error '.$validator->errors()]);
        }
        $user->email = $input['correo'];
        $user->nombre = $input['nombre'];
        $user->empresa = $input['empresa'];
        $user->cargo = $input['cargo'];
        if($request->file('avatar')){
            try {
                try{
                    $user->avatar != 'user.png' ? unlink(public_path('img/profile/').$user->avatar) : null;
                }catch (\Exception $e){
                }
                $file = $filename = $input['nombre'].".".$request->avatar->extension();
                $request->avatar->move(public_path("img/profile"), $filename);
                $user->avatar = $file;
            }catch (\Exception $e){
                return back()->withErrors(['validacion' => $e->getMessage()]);
            }
        }
        $user->save();
        $user->removeRole($user->roles[0]->id);
        $user->assignRole([$input['rol']['id']]);
        return redirect()->route('listar_usuarios')->with('message', 'Usuario Actualizado con Éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if(!$user) return back()->withErrors(['validacion' => 'Este usuario no existe']);
        if($user->id == Auth::user()->id) return back()->withErrors(['validacion' => 'No puede eliminar su propio usuario']);
        $user->delete();
        try{
            $user->avatar != 'user.png' ? unlink(public_path('img/profile/').$user->avatar) : null;
        }catch (\Exception $e){
        }
        return redirect()->route('listar_usuarios')->with('message', 'Usuario Eliminado con Éxito');
    }
}
