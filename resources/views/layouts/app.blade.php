<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Laravel Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('calculator.index') }}">Laravel Calculator</a>
    </div>
</nav>

<main>
    @yield('content')
</main>

<footer class="text-center mt-4 mb-3 text-muted">
    <small>© {{ date('Y') }} Laravel Calculator</small>
</footer>
</body>
</html>
