<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Laravel Architecture Explorer' }}</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            color: #1f2937;
        }

        nav {
            background: #111827;
            padding: 15px 30px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #f9fafb;
        }

        .flow {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .step {
            width: 80%;
            padding: 18px;
            text-align: center;
            background: #eef2ff;
            border: 2px solid #6366f1;
            border-radius: 10px;
        }

        .arrow {
            font-size: 25px;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            background: #e5e7eb;
        }
    </style>
</head>

<body>

<nav>
    <a href="{{ route('architecture.index') }}">Architecture</a>
    <a href="{{ route('lifecycle') }}">Request Lifecycle</a>
    <a href="{{ route('environment') }}">Environment</a>
    <a href="{{ route('about') }}">About</a>
</nav>

<div class="container">
    @yield('content')
</div>

</body>
</html>