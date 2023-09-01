<?php

namespace Database\Seeders;

use App\Models\Empresa;
use App\Models\Permiso;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Comando para Correr el Seeder*/
        /*php artisan db:seed --class=AdminUserSeeder*/
        $empresa = new Empresa();
        $empresa->nombre = 'Laboratorio Clícino y Patológico';
        $empresa->save();

        $user = User::create([
            'nombre' => 'Eddy Javier Jorge Herrera',
            'email' => 'eddyjj92@gmail.com',
            'empresa_id' => $empresa->id,
            'cargo' => 'Desarrollador',
            'avatar' => 'user.png',
            'password' => bcrypt('Ej8547/*-'),
            'conexion' => []
        ]);
        $role = Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
