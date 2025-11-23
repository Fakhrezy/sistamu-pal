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

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #4b57a2 100%);
            margin: 0;
            padding: 0;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
        }

        .login-left {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: white;
            background-image: url('/images/pal-gd.jpg');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            position: relative;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(2px);
        }

        .login-right {
            width: 400px;
            background: white;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-box {
            width: 100%;
            max-width: 350px;
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

        .welcome-section {
            text-align: center;
            color: #333;
            position: relative;
            z-index: 2;
        }

        .welcome-section h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.8);
            color: #2c3e50;
        }

        .welcome-section p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.8);
            color: #34495e;
            font-weight: 500;
        }



        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .login-left {
                flex: none;
                min-height: 40vh;
            }

            .login-right {
                width: 100%;
                min-height: 60vh;
            }

            .welcome-section h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Left Side - Welcome Section -->
        <div class="login-left">
            <div class="welcome-section">
                <div class="mb-4">
                    <x-application-logo class="mx-auto" style="height: 80px;" />
                </div>
                <h1>Selamat Datang</h1>
                <p>Sistem Informasi Buku Tamu Digital<br>PERUMDA PALJAYA</p>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="login-right">
            <div class="login-box">
                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
