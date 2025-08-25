<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

enum Operation: string
{
    case ADD = 'add';
    case SUBTRACT = 'subtract';
    case MULTIPLY = 'multiply';
    case DIVIDE = 'divide';
    case MOD = 'mod';

    public function label(): string
    {
        return match ($this) {
            self::ADD => 'Сложение',
            self::SUBTRACT => 'Вычитание',
            self::MULTIPLY => 'Умножение',
            self::DIVIDE => 'Деление',
            self::MOD => 'Остаток от деления',
        };
    }

    public function symbol(): string
    {
        return match ($this) {
            self::ADD => '+',
            self::SUBTRACT => '-',
            self::MULTIPLY => '×',
            self::DIVIDE => '÷',
            self::MOD => '%',
        };
    }

    public function calculate(float|int $a, float|int $b): float|int|string|null
    {
        return match ($this) {
            self::ADD => $a + $b,
            self::SUBTRACT => $a - $b,
            self::MULTIPLY => $a * $b,
            self::DIVIDE => $b != 0 ? $a / $b : 'Ошибка: деление на 0',
            self::MOD => $b != 0 ? $a % $b : 'Ошибка: деление на 0',
        };
    }
}

class CalculatorController extends Controller
{
    private const CACHE_KEY = 'calculator_history';
    private const MAX_HISTORY = 5;

    //TODO: У функций указывай тип который должен вернуться
    public function index()
    {
        $history = Cache::get(self::CACHE_KEY, []);
        $result = session('result'); // покажем результат после редиректа
        return view('calculator.index', compact('history', 'result'));
    }

    public function calculate(Request $request)
    {
        //TODO: Что такое Request и нахуй он нужен
        // TODO: вынеси в отдельный FormRequest
        $request->validate([
            'operation' => 'required|string|in:add,subtract,multiply,divide,mod',
            'a'         => 'required|numeric',
            'b'         => 'required|numeric',
        ]);

        // TODO: ограничь до размеров integer
        $a = (float)$request->input('a');
        $b = (float)$request->input('b');
        $operation = Operation::from($request->input('operation'));

        $result = $operation->calculate($a, $b);

        $history = Cache::get(self::CACHE_KEY, []);
        $history[] = [
            'a'         => $a,
            'b'         => $b,
            'operation' => $operation->label(),
            'symbol'    => $operation->symbol(),
            'result'    => $result,
            'time'      => now()->format('H:i:s'),
        ];
        if (count($history) > self::MAX_HISTORY) {
            array_shift($history);
        }
        Cache::put(self::CACHE_KEY, $history, now()->addHours(24));

        // Важно: всегда возвращаемся на /calculator
        return redirect()->route('calculator.index')->with('result', $result);
    }

    //TODO: определись баран
    public function apiCalculate(Request $request)
    {
        //TODO: FormRequest
        $request->validate([
            'operation' => 'required|string|in:add,subtract,multiply,divide,mod',
            'a'         => 'required|numeric',
            'b'         => 'required|numeric',
        ]);

        $a = (float)$request->input('a');
        $b = (float)$request->input('b');
        $operation = Operation::from($request->input('operation'));
        $result = $operation->calculate($a, $b);

        $history = Cache::get(self::CACHE_KEY, []);
        $history[] = [
            'a'         => $a,
            'b'         => $b,
            'operation' => $operation->label(),
            'symbol'    => $operation->symbol(),
            'result'    => $result,
            'time'      => now()->format('H:i:s'),
        ];
        if (count($history) > self::MAX_HISTORY) {
            array_shift($history);
        }
        Cache::put(self::CACHE_KEY, $history, now()->addHours(24));

        return response()->json(['result' => $result, 'history' => $history]);
    }
}
