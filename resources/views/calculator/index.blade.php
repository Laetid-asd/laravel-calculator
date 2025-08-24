<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Калькулятор</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .calc-input { width: 120px; text-align: center; font-size: 1.1rem; }
        .op-btn { min-width: 55px; font-size: 1.2rem; }
    </style>
</head>
<body class="bg-light">

<div class="container py-4">
    <h2 class="text-center mb-4">🧮 Калькулятор</h2>

    <form action="{{ route('calculator.calculate') }}" method="POST" class="mb-4">
        @csrf
        <table class="table table-bordered text-center align-middle">
            <thead class="table-light">
            <tr>
                <th>A</th><th>Операция</th><th>B</th><th>=</th><th>Ответ</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><input type="number" step="any" name="a" class="form-control calc-input" value="{{ old('a') }}" required></td>
                <td>
                    @php $sel = old('operation','add'); @endphp
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        @foreach([
                            'add' => '+', 'subtract' => '−', 'multiply' => '×', 'divide' => '÷', 'mod' => '%'
                        ] as $op => $sym)
                            <input type="radio" class="btn-check" name="operation" id="op-{{ $op }}" value="{{ $op }}" {{ $sel==$op?'checked':'' }}>
                            <label for="op-{{ $op }}" class="btn btn-outline-dark op-btn">{{ $sym }}</label>
                        @endforeach
                    </div>
                </td>
                <td><input type="number" step="any" name="b" class="form-control calc-input" value="{{ old('b') }}" required></td>
                <td><button class="btn btn-success">=</button></td>
                <td class="fw-bold">{{ session('result') ?? '—' }}</td>
            </tr>
            </tbody>
        </table>
    </form>

    {{-- История --}}
    <h5 class="text-center">📜 История</h5>
    @if(!empty($history))
        <table class="table table-hover text-center align-middle">
            <thead class="table-light">
            <tr><th>A</th><th>Опер.</th><th>B</th><th>=</th><th>Ответ</th><th>Время</th></tr>
            </thead>
            <tbody>
            @foreach($history as $h)
                <tr>
                    <td>{{ $h['a'] }}</td>
                    <td>{{ $h['symbol'] }}</td>
                    <td>{{ $h['b'] }}</td>
                    <td>=</td>
                    <td class="fw-bold">{{ $h['result'] }}</td>
                    <td class="text-muted small">{{ $h['time'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p class="text-center text-muted">История пуста</p>
    @endif
</div>

</body>
</html>
