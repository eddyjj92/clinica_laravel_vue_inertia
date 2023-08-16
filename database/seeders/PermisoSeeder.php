<?php

namespace Database\Seeders;

use App\Models\Permiso;
use Illuminate\Database\Seeder;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Comando para Correr el Seeder*/
        /*php artisan db:seed --class=PermisoSeeder*/
        $permisos = [
            'registrar-usuario','editar-usuario','ver-usuario','eliminar-usuario',
            'registrar-empresa','editar-empresa','ver-empresa','eliminar-empresa',
            'editar-cuestionario','ver-cuestionario','eliminar-cuestionario',
            'buscar-usuario', 'buscar-empresa', 'buscar-cuestionario'
        ];

        foreach ($permisos as $permiso) {
            Permiso::create(['permiso' => $permiso]);
        }
    }
}
