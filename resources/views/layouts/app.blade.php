<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Laravel App')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">

<header class="bg-gray-800 text-white">
    <nav class="container mx-auto px-4 py-3 flex gap-6">
        <a href="{{ route('calculator.index') }}" class="hover:underline">🧮 Калькулятор</a>
        <a href="{{ route('todo.index') }}" class="hover:underline">✅ ToDo List</a>
    </nav>
</header>

<main class="container mx-auto px-4 py-6 flex-1">
    @yield('content')
</main>

<footer class="bg-gray-900 text-gray-300 text-sm text-center py-3">
    Demo • {{ date('Y') }}
</footer>
</body>
</html>
