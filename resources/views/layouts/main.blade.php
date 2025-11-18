<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>sistamu paljaya</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-pal.png') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Time picker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        /* Custom Pagination Styles */
        .pagination {
            margin: 0;
            display: flex;
            padding-left: 0;
            list-style: none;
        }

        .page-item {
            margin: 0 2px;
        }

        .page-link {
            padding: 0.5rem 0.75rem;
            min-width: 40px;
            text-align: center;
            color: #333;
            background-color: #fff;
            border: 1px solid #dee2e6;
            transition: all 0.2s ease-in-out;
        }

        .page-item:first-child .page-link,
        .page-item:last-child .page-link {
            border-radius: 0.25rem;
        }

        .page-link:hover {
            z-index: 2;
            color: #0056b3;
            text-decoration: none;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #212529;
            border-color: #212529;
        }

        .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
        }

        /* Custom Alert Style */
        .alert-info {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            color: #333;
        }

        .sidebar {
            min-height: 100vh;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar .nav-link {
            color: #ffffff;
            padding: 0.8rem 1rem;
            border-radius: 4px;
            margin: 0.2rem 0;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #e9ecef;
            color: #0d6efd;
        }

        .sidebar .nav-link i {
            margin-right: 0.5rem;
        }

        .content-wrapper {
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .brand-wrapper {
            padding: 1rem;
            background-color: #212529;
            margin-bottom: 1rem;
            display: flex;
            justify-content: center;
        }

        .brand-wrapper .navbar-brand {
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
            justify-content: center;
        }

        /* Custom Table Header Style */
        .table>thead.table-gray-dark>tr {
            background-color: #495057 !important;
            color: white !important;
        }

        .table>thead.table-gray-dark th {
            background-color: #495057 !important;
            color: white !important;
        }

        /* Dropdown Menu Style */
        .dropdown-menu {
            border-radius: 0.25rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 p-0 bg-dark sidebar">
                <div class="brand-wrapper">
                    <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                        <img src="{{ asset('images/paljaya-logo.png') }}" alt="Paljaya Logo" height="30">
                    </a>
                </div>
                <div class="px-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                                href="{{ route('home') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('visitors.create') ? 'active' : '' }}"
                                href="{{ route('visitors.create') }}">
                                <i class="bi bi-person-plus"></i> Input Tamu
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('visitors.index') ? 'active' : '' }}"
                                href="{{ route('visitors.index') }}">
                                <i class="bi bi-table"></i> Data Tamu
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                                href="{{ route('users.index') }}">
                                <i class="bi bi-people-fill"></i> Kelola User
                            </a>
                        </li>
                        <!-- Logout -->
                        <li class="nav-item mt-4">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="nav-link" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 content-wrapper p-4">


                @yield('content')
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @stack('scripts')

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        });
    </script>
    @endif

    @if(session('status'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('status') }}',
                icon: 'success',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        });
    </script>
    @endif
</body>

</html>