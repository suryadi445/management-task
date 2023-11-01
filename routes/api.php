<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\SkillController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('task')->group(function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::get('edit/{id}', [TaskController::class, 'show']);
    Route::post('/', [TaskController::class, 'store']);
    Route::put('update/{id}', [TaskController::class, 'update']);
    Route::delete('{id}', [TaskController::class, 'destroy']);
});

Route::prefix('project')->group(function () {
    Route::get('/', [ProjectController::class, 'index']);
    Route::get('edit/{id}', [ProjectController::class, 'show']);
    Route::post('/save', [ProjectController::class, 'store']);
    Route::put('update/{id}', [ProjectController::class, 'update']);
    Route::delete('{id}', [ProjectController::class, 'destroy']);
});

Route::prefix('karyawan')->group(function () {
    Route::get('/', [KaryawanController::class, 'index']);
    Route::post('/save', [KaryawanController::class, 'store']);
    Route::get('/edit/{id}', [KaryawanController::class, 'show']);
    Route::put('/update/{id}', [KaryawanController::class, 'update']);
    Route::delete('/delete/{id}', [KaryawanController::class, 'destroy']);
});

Route::prefix('jabatan')->group(function () {
    Route::get('/', [JabatanController::class, 'index']);
    Route::post('/save', [JabatanController::class, 'store']);
    Route::put('/update/{id}', [JabatanController::class, 'update']);
    Route::delete('/delete/{id}', [JabatanController::class, 'destroy']);
});

Route::prefix('keahlian')->group(function () {
    Route::get('/', [SkillController::class, 'index']);
    Route::post('/save', [SkillController::class, 'store']);
    Route::put('/update/{id}', [SkillController::class, 'update']);
    Route::delete('/delete/{id}', [SkillController::class, 'destroy']);
});

Route::prefix('status')->group(function () {
    Route::get('/', [StatusController::class, 'index']);
    Route::post('/save', [StatusController::class, 'store']);
    Route::put('/update/{id}', [StatusController::class, 'update']);
    Route::delete('/delete/{id}', [StatusController::class, 'destroy']);
});
