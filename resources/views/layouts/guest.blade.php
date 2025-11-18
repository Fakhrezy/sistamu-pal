<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'sistamu paljaya') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-pal.png') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-container a {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 1rem;
        }

        .logo-container img {
            height: 60px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <div class="logo-container">
                <a href="/" class="d-flex justify-content-center">
                    <x-application-logo />
                </a>
                <h4 class="mt-2">SISTEM INFORMASI BUKU TAMU DIGITAL</h4>
            </div>

            {{ $slot }}
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>