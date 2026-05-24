<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>About Us | Secure Workspace</title>
    
    <!-- Link CSS using global_asset helper -->
    <link rel="stylesheet" href="{{ global_asset('build/prod/css/about.css') }}">
</head>
<body>

    <div class="layout-container">
        <!-- Sidebar Navigation -->
        <aside>
            <div class="brand">PortalHub</div>
            <ul class="nav-menu">
                <li class="nav-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="nav-item active"><a href="{{ route('about') }}">About Us</a></li>
                <li class="nav-item"><a href="{{ route('contact') }}">Contact Us</a></li>
                <li class="nav-item"><a href="{{ route('login') }}">Sign Out</a></li>
            </ul>
        </aside>

        <!-- Main Workspace -->
        <main class="main-content">
            <header>
                <h2>About Our Vision</h2>
                <div class="avatar">DJ</div>
            </header>

            <!-- About Hero View -->
            <div class="about-hero">
                <h1>Crafting Secure Account Workspaces</h1>
                <p>PortalHub is a premier dashboard application designed to bring together lightning-fast performance, elegant aesthetics, and absolute data privacy. Under the stewardship of Darshan Joshi, our primary mission remains centered around giving developers and teams high-performance frameworks that are responsive, state-of-the-art, and completely safe.</p>
            </div>

            <!-- Vision Core Values timeline cards -->
            <div class="vision-timeline">
                <div class="value-card">
                    <h3>High Performance</h3>
                    <p>Designed around optimized modular architectures and custom-rendered assets for immediate responsiveness and fast loads.</p>
                </div>
                
                <div class="value-card">
                    <h3>Absolute Security</h3>
                    <p>Double-factor frameworks, secure encryption protocols, and zero trust databases to defend client data profiles.</p>
                </div>

                <div class="value-card">
                    <h3>Visual Aesthetics</h3>
                    <p>Stunning dark-mode layouts, harmonious tailored color gradients, and micro-interaction animations to wow users.</p>
                </div>
            </div>
        </main>
    </div>

    <!-- Script JS using global_asset helper -->
    <script src="{{ global_asset('build/prod/js/about.js') }}"></script>
</body>
</html>
