<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Us | Secure Workspace</title>
    
    <!-- Link CSS using global_asset helper -->
    <link rel="stylesheet" href="{{ global_asset('build/prod/css/contact.css') }}">
</head>
<body>

    <div class="layout-container">
        <!-- Sidebar Navigation -->
        <aside>
            <div class="brand">PortalHub</div>
            <ul class="nav-menu">
                <li class="nav-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('about') }}">About Us</a></li>
                <li class="nav-item active"><a href="{{ route('contact') }}">Contact Us</a></li>
                <li class="nav-item"><a href="{{ route('login') }}">Sign Out</a></li>
            </ul>
        </aside>

        <!-- Main Workspace -->
        <main class="main-content">
            <header>
                <h2>Get In Touch</h2>
                <div class="avatar">DJ</div>
            </header>

            <div class="contact-grid">
                <!-- Info cards side -->
                <div class="contact-info">
                    <h1>Let's Connect</h1>
                    <p>Have inquiries, support tickets, or configuration questions? Fill out the secure form, and our system administrators will reach out directly.</p>
                    
                    <div class="info-item">
                        <div>
                            <h4>Admin Support</h4>
                            <p>support@portalhub.live</p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div>
                            <h4>Secure Server Location</h4>
                            <p>Node 12 - Asia Pacific West</p>
                        </div>
                    </div>
                </div>

                <!-- Form card side -->
                <div class="contact-form-card">
                    <form id="contactForm" action="#" method="POST">
                        @csrf

                        <!-- Name Field (Static filled for Darshan) -->
                        <div class="input-group">
                            <input type="text" name="name" id="name" value="Darshan Joshi" required autocomplete="off">
                            <label for="name">Your Name</label>
                        </div>

                        <!-- Email Field -->
                        <div class="input-group">
                            <input type="email" name="email" id="email" required autocomplete="off">
                            <label for="email">Email Address</label>
                        </div>

                        <!-- Message Field -->
                        <div class="input-group textarea-group">
                            <textarea name="message" id="message" required></textarea>
                            <label for="message">Your Message</label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-submit">Send Secure Message</button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <!-- Script JS using global_asset helper -->
    <script src="{{ global_asset('build/prod/js/contact.js') }}"></script>
</body>
</html>
