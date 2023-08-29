<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //*php artisan db:seed --class=PermissionSeeder*//
        $permisos = [
            //Operaciones sobre tabla roles
            'ver-rol','crear-rol','editar-rol','borrar-rol',
            //Operacions sobre tabla usuarios
            'ver-usuario','crear-usuario','editar-usuario','borrar-usuario',
            //Operacions sobre tabla empresas
            'registrar-empresa','editar-empresa','ver-empresa','eliminar-empresa',
            //Operacions sobre tabla cuestionarios
            'editar-cuestionario','ver-cuestionario','eliminar-cuestionario',
            //Operacions sobre tabla búsquedas
            'buscar-usuario', 'buscar-empresa', 'buscar-cuestionario'
        ];

        foreach($permisos as $permiso) {
            Permission::create(['name'=>$permiso]);
        }
    }
}
