<?php

use App\Http\Controllers\API\v1\ConsultationController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/consultations', [ConsultationController::class, 'index'])->name('api.consultation.index');
Route::post('/consultations', [ConsultationController::class, 'store'])->name('api.consultation.store');
