<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlloStudent - Dashboard Produktivitas</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk Ikon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #0d6efd;
            --soft-blue: #e7f1ff;
            --sidebar-width: 250px;
        }
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background-color: var(--primary-blue);
        }
        .sidebar {
            height: 100vh;
            width: var(--sidebar-width);
            position: fixed;
            top: 56px; /* Navbar height */
            left: 0;
            background-color: #fff;
            box-shadow: 2px 0 5px rgba(0,0,0,0.05);
            padding-top: 20px;
            z-index: 1000;
        }
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            margin-top: 56px;
        }
        .nav-link {
            color: #555;
            padding: 10px 20px;
            font-weight: 500;
        }
        .nav-link:hover, .nav-link.active {
            background-color: var(--soft-blue);
            color: var(--primary-blue);
            border-right: 3px solid var(--primary-blue);
        }
        .card-custom {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }
        .card-custom:hover {
            transform: translateY(-5px);
        }
        .card-icon {
            font-size: 2rem;
            opacity: 0.8;
        }
        body.dark-mode {
        background-color: #1a1a2e;
        color: #e0e0e0;
        }
        .sidebar.dark-mode {
            background-color: #16213e;
            color: #fff;
        }
        .sidebar.dark-mode .nav-link {
            color: #adb5bd;
        }
        .sidebar.dark-mode .nav-link.active {
            background-color: #0f3460;
            color: #fff;
            border-right: 3px solid #4cc9f0;
        }
        .level-badge {
            background: linear-gradient(45deg, #FFD700, #FFA500);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                top: 0;
            }
            .main-content {
                margin-left: 0;
                margin-top: 20px;
            }
        }
    </style>
</head>
<!-- Update Body Tag untuk menerapkan Dark Mode -->
<body class="{{ auth()->user()->theme === 'dark' ? 'dark-mode' : '' }}">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fas fa-graduation-cap me-2"></i>AlloStudent</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <!-- Update Sidebar untuk menampilkan Level dan Link Settings -->
    <div class="sidebar d-flex flex-column {{ auth()->user()->theme === 'dark' ? 'dark-mode' : '' }}">
        <!-- User Info & Gamification -->
        <div class="text-center px-3 py-3 border-bottom">
            <span class="level-badge mb-2">Level {{ auth()->user()->level }}</span>
            <p class="mb-0 small text-muted">XP: {{ auth()->user()->xp }} / 500</p>
            <div class="progress" style="height: 5px;">
                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ (auth()->user()->xp % 500) / 5 }}%;" aria-valuenow="{{ auth()->user()->xp }}" aria-valuemin="0" aria-valuemax="500"></div>
            </div>
        </div>

        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-home me-2"></i> Dashboard
        </a>
        <a href="{{ route('finances.index') }}" class="nav-link {{ request()->routeIs('finances.*') ? 'active' : '' }}">
            <i class="fas fa-wallet me-2"></i> Keuangan
        </a>
        <!-- Menu Analisis Baru -->
        <a href="{{ route('finances.analysis') }}" class="nav-link {{ request()->routeIs('finances.analysis') ? 'active' : '' }}">
            <i class="fas fa-chart-pie me-2"></i> Analisis Keuangan
        </a>
        <a href="{{ route('tasks.index') }}" class="nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
            <i class="fas fa-tasks me-2"></i> Tugas
        </a>
        <a href="{{ route('schedules.index') }}" class="nav-link {{ request()->routeIs('schedules.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt me-2"></i> Jadwal
        </a>
        <!-- Menu Settings Baru -->
        <a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
            <i class="fas fa-cog me-2"></i> Pengaturan
        </a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>