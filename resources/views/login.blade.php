<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | Secure Portal</title>
    
    <!-- Link CSS using global_asset helper -->
    <link rel="stylesheet" href="{{ global_asset('build/prod/css/login.css') }}">
</head>
<body>

    <div class="login-container">
        <div class="login-header">
            <h1>Welcome Back</h1>
            <p>Please enter your credentials to login</p>
        </div>

        <form id="loginForm" action="#" method="POST">
            @csrf

            <!-- Email Field -->
            <div class="input-group">
                <input type="email" name="email" id="email" required autocomplete="off">
                <label for="email">Email Address</label>
            </div>

            <!-- Password Field -->
            <div class="input-group">
                <input type="password" name="password" id="password" required autocomplete="off">
                <label for="password">Password</label>
            </div>

            <!-- Extra options -->
            <div class="extra-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>
                <a href="#" class="forgot-password">Forgot Password?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit">Sign In</button>
        </form>

        <!-- Signup Link Footer -->
        <div class="login-footer">
            <p>Don't have an account? <a href="#">Create One</a></p>
        </div>
    </div>

    <!-- Script JS using global_asset helper -->
    <script src="{{ global_asset('build/prod/js/login.js') }}"></script>
</body>
</html>
