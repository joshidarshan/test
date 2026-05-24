<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard | Secure Workspace</title>
    
    <!-- Link CSS using global_asset helper -->
    <link rel="stylesheet" href="{{ global_asset('build/prod/css/dashboard.css') }}">
</head>
<body>

    <!-- Sidebar Navigation -->
    <aside>
        <div class="brand">PortalHub</div>
        <ul class="nav-menu">
            <li class="nav-item active"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="nav-item"><a href="{{ route('about') }}">About Us</a></li>
            <li class="nav-item"><a href="{{ route('contact') }}">Contact Us</a></li>
            <li class="nav-item"><a href="{{ route('login') }}">Sign Out</a></li>
        </ul>
    </aside>

    <!-- Main Workspace -->
    <main class="dashboard-main">
        <header>
            <div class="welcome-text">
                <h2>Workspace Dashboard</h2>
            </div>
            
            <div class="user-profile">
                <div class="profile-info">
                    <h4>Darshan Joshi</h4>
                    <span>Static Account Session</span>
                </div>
                <div class="avatar">DJ</div>
            </div>
        </header>

        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <h1>Welcome back, Darshan</h1>
            <p>Your secure account environment is fully loaded. Check recent system statistics, manage profiles, and review quick actions directly from your workspace.</p>
        </div>

        <!-- Metrics cards -->
        <div class="stats-grid">
            <!-- Stat 1 -->
            <div class="stat-card">
                <div class="stat-header">
                    <span>Monthly Visitors</span>
                </div>
                <div class="stat-value" data-suffix="K">12K</div>
                <div class="stat-indicator">
                    <span>&uarr; 12.4% this month</span>
                </div>
            </div>

            <!-- Stat 2 -->
            <div class="stat-card">
                <div class="stat-header">
                    <span>Security Audits</span>
                </div>
                <div class="stat-value">98</div>
                <div class="stat-indicator">
                    <span>All services healthy</span>
                </div>
            </div>

            <!-- Stat 3 -->
            <div class="stat-card">
                <div class="stat-header">
                    <span>Server Uptime</span>
                </div>
                <div class="stat-value" data-suffix="%">100%</div>
                <div class="stat-indicator">
                    <span>Consistent performance</span>
                </div>
            </div>
        </div>
    </main>

    <!-- Script JS using global_asset helper -->
    <script src="{{ global_asset('build/prod/js/dashboard.js') }}"></script>
</body>
</html>
