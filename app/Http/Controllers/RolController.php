<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Testing\Assert;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Auth::user()->can('ver-rol')) return redirect('dashboard')->withErrors(['validacion' => 'No tiene permisos para ver los roles de usuario']);
        $roles = Role::all();
        foreach ($roles as $role){
            $role->permissions->all();
        }
        return Inertia::render('Roles/Index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Auth::user()->can('crear-rol')) return redirect('dashboard')->withErrors(['validacion' => 'No tiene permisos para crear roles de usuario']);
        return Inertia::render('Roles/Registrar', ['permisos' => Permission::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('crear-rol')) return redirect('dashboard')->withErrors(['validacion' => 'No tiene permisos para crear roles de usuario']);
        $input = $request->all();
        $validator = Validator::make($input, [
            'nombre' => 'required',
        ]);
        if($validator->fails()){
            return back()->withErrors(['validacion' => 'Ha ocurrido un error '.$validator->errors()]);
        }
        $rol = new Role();
        $rol->name = $input['nombre'];
        $rol->syncPermissions($input['permisos']);
        $rol->save();
        return redirect()->route('roles.index')->with('message', 'Rol de Usuario Registrado con Éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        if(!Auth::user()->can('editar-rol')) return redirect('dashboard')->withErrors(['validacion' => 'No tiene permisos para editar los roles de usuario']);
        $role->permissions->all();
        return Inertia::render('Roles/Editar', [
            'rol' => $role,
            'permisos' => Permission::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        if(!Auth::user()->can('editar-rol')) return redirect('dashboard')->withErrors(['validacion' => 'No tiene permisos para editar los roles de usuario']);
        $input = $request->all();
        $validator = Validator::make($input, [
            'nombre' => 'required',
        ]);
        if($validator->fails()){
            return back()->withErrors(['validacion' => 'Ha ocurrido un error '.$validator->errors()]);
        }
        $role->name = $input['nombre'];
        $role->syncPermissions($input['permisos']);
        $role->save();
        return redirect()->route('roles.index')->with('message', 'Rol de Usuario actualizado con Éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if(!Auth::user()->can('eliminar-rol')) return redirect('dashboard')->withErrors(['validacion' => 'No tiene permisos para eliminar los roles de usuario']);
        if($role->id == Auth::user()->roles[0]->id) return back()->withErrors(['validacion' => 'No puede eliminar su propio Rol de Usuario']);
        $role->delete();
        return redirect()->route('roles.index')->with('message', 'Rol de Usuario Eliminado con Éxito');
    }
}
