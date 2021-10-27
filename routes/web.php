<?php

use App\Http\Controllers\Paginas;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('planificacion', [Paginas::class, "planificacion"])->name('pagina.planificacion')->middleware(['auth:sanctum', 'verified', 'role:funcionario']);
Route::get('propuesta', [Paginas::class, "propuesta"])->name('pagina.propuesta')->middleware(['auth:sanctum', 'verified', 'role:funcionario']);
Route::get('especialista', [Paginas::class, "especialista"])->name('pagina.especialista')->middleware(['auth:sanctum', 'verified', 'role:especialista']);
Route::get('formulario', [Paginas::class, "formulario"])->name('pagina.formulario')->middleware(['auth:sanctum', 'verified']);