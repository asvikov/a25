<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/salary', [\App\Http\Controllers\HourSegmentController::class, 'store']);
Route::post('/employees', [\App\Http\Controllers\EmployeeController::class, 'store']);
Route::post('/employees/{id}/payall', [\App\Http\Controllers\HourSegmentController::class, 'setAllPaid']);
Route::get('/salary', [\App\Http\Controllers\HourSegmentController::class, 'getCreated']);


