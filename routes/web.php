<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\TodoListController;

Route::get('/calculator', [CalculatorController::class, 'index'])->name('calculator.index');
Route::post('/calculator/calculate', [CalculatorController::class, 'calculate'])->name('calculator.calculate');

Route::get('/todo-list', [TodoListController::class, 'index'])->name('todo.index');
Route::post('/todo-list/store', [TodoListController::class, 'store'])->name('todo.store');
Route::post('/todo-list/update/{id}', [TodoListController::class, 'update'])->name('todo.update');
Route::post('/todo-list/complete/{id}', [TodoListController::class, 'complete'])->name('todo.complete');
Route::delete('/todo-list/delete/{id}', [TodoListController::class, 'destroy'])->name('todo.destroy');

Route::get('/', fn () => redirect()->route('calculator.index'));
