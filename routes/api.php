<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\TodoListController;

// API для калькулятора
Route::post('/calculator/calculate', [CalculatorController::class, 'apiCalculate']);

//TODO: определись баран
// API для ToDo
Route::get('/todo', [TodoListController::class, 'apiIndex']);
Route::post('/todo', [TodoListController::class, 'apiStore']);
Route::post('/todo/{id}/update', [TodoListController::class, 'apiUpdate']);
Route::post('/todo/{id}/complete', [TodoListController::class, 'apiComplete']);
Route::delete('/todo/{id}', [TodoListController::class, 'apiDestroy']);
