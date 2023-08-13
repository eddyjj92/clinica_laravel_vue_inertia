<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
        $user = User::create([
            'nombre' => 'Eddy Javier Jorge Herrera',
            'email' => 'eddyjj92@gmail.com',
            'empresa' => 'Laboratorio Clínico y Patológico',
            'cargo' => 'Desarrollador',
            'avatar' => 'user.png',
            'password' => bcrypt('Ej8547/*-'),
        ]);
    }
}
