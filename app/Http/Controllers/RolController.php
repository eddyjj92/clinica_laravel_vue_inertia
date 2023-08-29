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
        return Inertia::render('Roles/Registrar', ['permisos' => Permission::all()]);
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
        if($role->id == Auth::user()->roles[0]->id) return back()->withErrors(['validacion' => 'No puede eliminar su propio Rol de Usuario']);
        $role->delete();
        return redirect()->route('roles.index')->with('message', 'Rol de Usuario Eliminado con Éxito');
    }
}
