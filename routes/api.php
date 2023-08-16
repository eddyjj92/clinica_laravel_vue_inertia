<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::controller(LoginController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
    Route::post('/databases', 'databases')->name('databases');
});

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('usuarios', UserController::class);
});

Route::get('datatables/es', function () {
    return response()->file(public_path('vendor/datatables/es-ES.json'));
})->name('datatables_es');

Route::controller(PdfController::class)->group(function () {
    Route::get('/pdf', 'stream')->name('pdf');
});


