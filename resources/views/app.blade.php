<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('/logo.ico') }}">
    <meta name="theme-color" content="#2b1138">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&family=PT+Serif&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="manifest" href="{{ url('manifest.json') }}">
</head>
<body class="bg-secondary">
    <div id="app"></div>
</body>
</html>
