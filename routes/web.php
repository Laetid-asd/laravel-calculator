<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculatorController;

Route::get('/calculator', [CalculatorController::class, 'index'])->name('calculator.index');
Route::post('/calculator/calculate', [CalculatorController::class, 'calculate'])->name('calculator.calculate');

