<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:admins');
Route::get('/test', function () {
    return response('ok', 200);
});


Route::group(['middleware' => ['auth:employees']], function() {
    Route::get('/logout', [\App\Http\Controllers\AuthEmployeeController::class, 'logout']);
    Route::post('/salary', [\App\Http\Controllers\HourSegmentController::class, 'store']);
});
Route::post('/login', [\App\Http\Controllers\AuthEmployeeController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth:admins']], function() {
    Route::get('/admin/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::resource('/employees', \App\Http\Controllers\EmployeeController::class)->except(['create', 'edit']);
    Route::post('/employees/{id}/payall', [\App\Http\Controllers\HourSegmentController::class, 'setAllPaid']);
});
Route::post('/admin/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::get('/salary', [\App\Http\Controllers\HourSegmentController::class, 'getCreated']);


