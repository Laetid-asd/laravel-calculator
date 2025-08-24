@extends('layouts.app')

@section('title', 'Калькулятор')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">🧮 Калькулятор</h1>
        <a href="{{ route('todo.index') }}" class="text-blue-600 hover:underline">→ К списку задач</a>
    </div>

    {{-- Ошибки валидации --}}
    @if ($errors->any())
        <div class="mb-4 p-3 rounded border border-red-300 bg-red-50">
            <ul class="list-disc pl-5 text-red-700">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Форма --}}
    <form action="{{ route('calculator.calculate') }}" method="POST" class="mb-6 grid grid-cols-1 sm:grid-cols-4 gap-2">
        @csrf
        <input type="number" step="any" name="a" required placeholder="Число A" value="{{ old('a') }}"
               class="border p-2 rounded">

        <select name="operation" class="border p-2 rounded">
            <option value="add"      @selected(old('operation')==='add')>+</option>
            <option value="subtract" @selected(old('operation')==='subtract')>-</option>
            <option value="multiply" @selected(old('operation')==='multiply')>×</option>
            <option value="divide"   @selected(old('operation')==='divide')>÷</option>
            <option value="mod"      @selected(old('operation')==='mod')>%</option>
        </select>

        <input type="number" step="any" name="b" required placeholder="Число B" value="{{ old('b') }}"
               class="border p-2 rounded">

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Вычислить</button>
    </form>

    {{-- Результат --}}
    @if(isset($result))
        <div class="mb-6 p-4 bg-green-100 border border-green-300 rounded">
            <strong>Результат:</strong> {{ $result }}
        </div>
    @elseif(session('result'))
        <div class="mb-6 p-4 bg-green-100 border border-green-300 rounded">
            <strong>Результат:</strong> {{ session('result') }}
        </div>
    @endif

    {{-- История --}}
    <h2 class="text-xl font-semibold mb-2">📜 История вычислений</h2>
    @if(!empty($history))
        <ul class="space-y-1">
            @foreach ($history as $row)
                <li class="border rounded p-2 bg-white">
                    <span class="text-gray-600">{{ $row['time'] }}</span> —
                    {{ $row['a'] }} {{ $row['symbol'] }} {{ $row['b'] }} = <b>{{ $row['result'] }}</b>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500">История пока пуста.</p>
    @endif
@endsection
