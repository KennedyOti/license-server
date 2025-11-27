<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>License Server - Secure License Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">License<span>Server</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary ms-2" href="{{ route('register') }}">Sign Up</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4>License<span>Server</span></h4>
                    <p class="mt-3">Secure, scalable license management for modern software applications.</p>
                </div>
                <div class="col-md-3">
                    <h5>Quick Links</h5>
                    <div class="footer-links d-flex flex-column">
                        <a href="#features">Features</a>
                        <a href="#about">About</a>
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Sign Up</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <h5>Contact</h5>
                    <div class="footer-links d-flex flex-column">
                        <a href="mailto:support@licenseserver.com">support@licenseserver.com</a>
                        <a href="#">Documentation</a>
                        <a href="#">API Reference</a>
                    </div>
                </div>
            </div>
            <hr class="my-4" style="border-color: #444;">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="copyright">© 2025 License Server. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>
