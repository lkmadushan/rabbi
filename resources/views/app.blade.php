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
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="manifest" href="{{ url('manifest.json') }}">
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-QVF4NZ2FME"></script>
</head>
<body class="bg-secondary">
    <div id="app"></div>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-QVF4NZ2FME');
    </script>
</body>
</html>
