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
            'ver-rol','crear-rol','editar-rol','eliminar-rol',
            //Operacions sobre tabla usuarios
            'ver-usuario','crear-usuario','editar-usuario','eliminar-usuario',
            //Operacions sobre tabla empresas
            'ver-empresa','crear-empresa','editar-empresa','eliminar-empresa',
            //Operacions sobre tabla solicitudes
            'ver-solicitud','crear-solicitud','editar-solicitud','eliminar-solicitud',
            //Operacions sobre tabla cuestionarios
            'ver-cuestionario','editar-cuestionario','eliminar-cuestionario',
            //Operacions sobre tabla búsquedas
            'buscar-usuario', 'buscar-empresa', 'buscar-cuestionario',
            'permisos-especiales'
        ];

        foreach($permisos as $permiso) {
            Permission::create(['name'=>$permiso]);
        }
    }
}
