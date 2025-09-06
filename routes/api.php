<?php

use App\Http\Controllers\ErrorLogController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\MachineErrorLogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/machines', [MachineController::class, 'index']);

Route::get('/machines/{id}', [MachineController::class, 'show']);

Route::put('/orders/{order}', [MachineController::class, 'updateOrder']);

Route::get('/machines/{machine}/error-logs', [MachineErrorLogController::class, 'index']);
Route::post('/machines/{machine}/error-logs', [MachineErrorLogController::class, 'store']);

// Error log routes
Route::put('/error-logs/{errorLog}', [ErrorLogController::class, 'update']);
Route::delete('/error-logs/{errorLog}', [ErrorLogController::class, 'destroy']);

Route::post('/machines/{machine}/stop', [MachineController::class, 'stop']);
Route::post('/machines/{machine}/resume', [MachineController::class, 'resume']);
