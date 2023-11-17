<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chiefly Quotes</title>
    <link rel="icon" href="/logo.ico">
    <meta name="theme-color" content="#6C2381">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&family=PT+Serif&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite('resources/js/app.js')
    <link rel="manifest" href="/manifest.json">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#662483',
                    },
                    fontFamily: {
                        sans: ["'PT Sans'", 'sans-serif'],
                        serif: ["'PT Serif'", 'serif'],
                    }
                }
            }
        }
    </script>
</head>
<body>
    <div id="app"></div>
</body>
</html>
