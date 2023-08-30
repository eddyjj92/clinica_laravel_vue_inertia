<?php

use App\Http\Controllers\BuscadorController;
use App\Http\Controllers\CuestionarioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', fn() => redirect('login'));

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'login')->name('auth');
    Route::get('/logout', 'logout')->name('logout');
});


Route::middleware(['auth','conexion'])->group( function () {
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');

    Route::controller(UserController::class)->group(function () {
        Route::get('/usuarios', 'index')->name('listar_usuarios');
        Route::get('/usuario/perfil/{user}', 'show')->name('perfil_usuario');
        Route::get('/usuario/registrar', 'create')->name('crear_usuario');
        Route::get('/usuario/editar/{user}', 'edit')->name('editar_usuario');
        Route::post('/usuario/registrar', 'store')->name('registrar_usuario');
        Route::post('/usuario/actualizar/{user}', 'update')->name('actualizar_usuario');
        Route::delete('/usuario/eliminar/{user}', 'destroy')->name('eliminar_usuario');
        Route::get('/usuario/enable_disable/{user}', 'enableDisable')->name('enable_disable_usuario');
    });

    Route::resource('roles', RolController::class);
    Route::resource('empresas', EmpresaController::class);
    Route::resource('solicitudes', SolicitudController::class);

    Route::get('/buscador/{key}', [BuscadorController::class, 'buscador'] )->name('buscador');

    Route::get('/certificado/{cuestionario}', [PdfController::class, 'stream']);

});

Route::resource('cuestionarios', CuestionarioController::class);
Route::post('/cuestionarios/create', [CuestionarioController::class, 'create']);
