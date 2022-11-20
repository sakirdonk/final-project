<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//routes untuk pasien
//menampilkan semua data pasien
Route::get('/patients', [PatientController::class, 'index']);

//menambah data pasien
Route::post('/patients', [PatientController::class, 'store']);

//menampilkan data lengkap seorang pasien
Route::get('/patients/{id}', [PatientController::class, 'show']);

//mengupdate data pasien
Route::put('/patients/{id}', [PatientController::class, 'update']);

//menghapus data pasien
Route::delete('/patients/{id}', [PatientController::class, 'destroy']);

//mencari seorang pasien
Route::get('/patients/search/{name}', [PatientController::class, 'search']);

//menapilkan data pasien yang positive
Route::get('/patients/status/positive', [PatientController::class, 'positive']);

//menampilkan data pasien yang sembuh
Route::get('/patients/status/recovered', [PatientController::class, 'recovered']);

//menampilkan data pasien yang meninggal dunia
Route::get('/patients/status/dead', [PatientController::class, 'dead']);