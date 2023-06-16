<?php

use App\Http\Controllers\AktivitasTanggalanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MakananTanggalanController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ShowAllAktivitasMakananController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/user/login', [LoginController::class, 'authenticate']);

Route::get('/user/logout', [LoginController::class, 'logout']);

Route::post('/user/register', [RegisterController::class, 'store']);

Route::post('/user/image/{user:email}', [UserController::class, 'ImageStore']);

Route::delete('/user/image/{user:email}', [UserController::class, 'ImageDelete']);

Route::post('/user/profil/{user:email}', [UserDataController::class, 'update']);

Route::get('/user/profil/{user:email}', [UserDataController::class, 'show']);

Route::get('/user/profil/image/{user:email}', [UserDataController::class, 'getImage']);

Route::post('/tanggal/aktivitas/{user:email}', [AktivitasTanggalanController::class, 'store']);


Route::post('/tanggal/makanan/{user:email}', [MakananTanggalanController::class, 'store']);

Route::get('/tanggal/aktivitas/{user:email}', [ShowAllAktivitasMakananController::class, 'show']);
