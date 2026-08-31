<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TrapApiController;
use App\Http\Controllers\Api\EntryApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\RekomendasiApiController;

Route::get('/test', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'API Pest Control aktif',
    ]);
});

//Auth
Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/user', [AuthApiController::class, 'user']);
});
//Traps
Route::get('/traps', [TrapApiController::class, 'index']);

Route::get('/traps/{trap}', [TrapApiController::class, 'show']);

//entry
Route::get('/entries', [EntryApiController::class, 'index']);
Route::get('/entries/{entry}', [EntryApiController::class, 'show']);
Route::post('/entries', [EntryApiController::class, 'store']);
Route::put('/entries/{entry}', [EntryApiController::class, 'update']);
Route::delete('/entries/{entry}', [EntryApiController::class, 'destroy']);

//rekomendasi Perbaikan

Route::get('/rekomendasi/{entry}', [RekomendasiApiController::class, 'show']);
Route::post('/rekomendasi/{entry}', [RekomendasiApiController::class, 'store']);
Route::put('/rekomendasi/{entry}', [RekomendasiApiController::class, 'update']);
Route::delete('/rekomendasi/{entry}', [RekomendasiApiController::class, 'destroy']);

Route::post('/cors-test', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'POST CORS berhasil',
    ]);
});