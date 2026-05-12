<?php
// Simple landing page for SIMPLE AUTH TEMPLATE
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SIMPLE AUTH TEMPLATE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-pKGvE+X7EJvX11RjHhVuw1mIwK3Z5ZgXYV5qbMOjOQ/7U2bZ3MxF05dhP1T5a0gH" crossorigin="anonymous">
    <style>
        :root {
            --brand-blue: #0d6efd;
            --brand-indigo: #6610f2;
            --surface: rgba(255, 255, 255, 0.95);
            --surface-strong: #f8f9fa;
            --text-dark: #212529;
        }
        * {
            box-sizing: border-box;
        }
        body {
            min-height: 100vh;
            margin: 0;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #050c2d 0%, #0d197d 45%, #4034b5 100%);
            color: white;
        }
        .page-nav {
            background: rgba(10, 18, 63, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .page-nav .nav-link {
            color: rgba(255, 255, 255, 0.85);
        }
        .page-nav .nav-link:hover,
        .page-nav .nav-link:focus {
            color: white;
        }
        .hero {
            padding: 5rem 0 4rem;
        }
        .hero-title {
            letter-spacing: -0.04em;
        }
        .hero-text {
            max-width: 660px;
        }
        .hero-card {
            border: none;
            border-radius: 1.5rem;
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(16px);
        }
        .hero-card h5 {
            color: var(--surface-strong);
        }
        .feature-card,
        .step-card {
            border: none;
            border-radius: 1.25rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }
        .feature-card .card-body,
        .step-card .card-body {
            min-height: 220px;
        }
        .feature-icon {
            width: 3rem;
            height: 3rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.9rem;
            background: rgba(13, 110, 253, 0.12);
            color: var(--brand-blue);
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .section-heading {
            letter-spacing: 0.03em;
        }
        .footer {
            padding: 3rem 0 1rem;
            color: rgba(255, 255, 255, 0.72);
        }
        .footer a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        @media (max-width: 767px) {
            .hero {
                padding-top: 3rem;
            }
        }
    </style>
</head>
<body>
    <header class="page-nav sticky-top">
        <nav class="navbar navbar-expand-lg navbar-dark container">
            <a class="navbar-brand fw-semibold" href="#">Simple Auth Template</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#landingNav" aria-controls="landingNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="landingNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#workflow">Workflow</a></li>
                    <li class="nav-item"><a class="nav-link" href="#start">Get Started</a></li>
                    <li class="nav-item ms-lg-3"><a class="btn btn-outline-light btn-sm" href="public/login.php">Login</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="container">
        <section class="row align-items-center hero">
            <div class="col-lg-6 text-center text-lg-start">
                <p class="text-uppercase text-white-50 fw-semibold mb-3">Open source authentication starter</p>
                <h1 class="display-5 fw-bold hero-title">Launch secure PHP login flows with a polished starter template.</h1>
                <p class="lead text-white-75 hero-text">Designed for developers who need a dependable auth foundation with clean UI, secure password handling, and a welcoming contributor experience.</p>
                <div class="d-flex flex-column flex-sm-row gap-3 mt-4 justify-content-center justify-content-lg-start">
                    <a class="btn btn-primary btn-lg px-4" href="public/register.php">Create account</a>
                    <a class="btn btn-outline-light btn-lg px-4" href="public/login.php">Login</a>
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0">
                <div class="hero-card p-4 p-md-5">
                    <div class="row g-3">
                        <div class="col-12">
                            <span class="badge bg-white text-dark rounded-pill mb-3">Trusted starter for PHP auth</span>
                            <h5 class="mb-3">Secure login and registration</h5>
                            <p class="text-white-75 mb-0">Built with modern Bootstrap layout, password hashing, and structured forms for a faster developer launch.</p>
                        </div>
                        <div class="col-6">
                            <div class="bg-white rounded-4 p-3 text-dark">
                                <p class="mb-1 text-uppercase fw-semibold small">Users</p>
                                <h3 class="mb-0">Ready</h3>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-white rounded-4 p-3 text-dark">
                                <p class="mb-1 text-uppercase fw-semibold small">Setup</p>
                                <h3 class="mb-0">Simple</h3>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mt-3">
                                <p class="mb-2 text-white-75">What is included</p>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-opacity-10 bg-white text-white">Login</span>
                                    <span class="badge bg-opacity-10 bg-white text-white">Register</span>
                                    <span class="badge bg-opacity-10 bg-white text-white">Session support</span>
                                    <span class="badge bg-opacity-10 bg-white text-white">Bootstrap UI</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="features" class="mt-5 pt-4">
            <div class="text-center mb-5">
                <p class="text-uppercase text-white-50 mb-2">Core Features</p>
                <h2 class="fw-bold section-heading">Everything a starter auth template should include.</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card p-4 bg-white text-dark h-100">
                        <div class="feature-icon">🔐</div>
                        <h5>Secure password handling</h5>
                        <p class="mb-0">Passwords are hashed before storage and verified with PHP's built-in auth functions.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4 bg-white text-dark h-100">
                        <div class="feature-icon">⚡</div>
                        <h5>Fast developer onboarding</h5>
                        <p class="mb-0">Clear file structure and easy-to-follow forms let you run auth flow in minutes.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4 bg-white text-dark h-100">
                        <div class="feature-icon">🎨</div>
                        <h5>Responsive interface</h5>
                        <p class="mb-0">Built with Bootstrap and modern layout patterns for mobile-first usability.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="workflow" class="mt-5 pt-4">
            <div class="row align-items-center gy-4">
                <div class="col-lg-6">
                    <h2 class="fw-bold section-heading">Workflow that keeps auth simple</h2>
                    <p class="text-white-75">From registration to login, the flow is kept intentional and easy to extend. This landing page is designed to help contributors find the value quickly.</p>
                    <div class="row g-3 mt-4">
                        <div class="col-12">
                            <div class="card step-card p-4 bg-white text-dark">
                                <strong class="d-block mb-2">Step 1</strong>
                                <span class="text-uppercase small text-muted">Register</span>
                                <p class="mb-0 mt-2">Create a new account with a simple form that captures username and password.</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card step-card p-4 bg-white text-dark">
                                <strong class="d-block mb-2">Step 2</strong>
                                <span class="text-uppercase small text-muted">Login</span>
                                <p class="mb-0 mt-2">Authenticate with secure validation and session handling for protected areas.</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card step-card p-4 bg-white text-dark">
                                <strong class="d-block mb-2">Step 3</strong>
                                <span class="text-uppercase small text-muted">Extend</span>
                                <p class="mb-0 mt-2">Add roles, email verification, or custom redirects without rebuilding the foundation.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card p-4 bg-white text-dark h-100">
                        <div class="card-body">
                            <h5 class="card-title">Project snapshot</h5>
                            <p class="text-muted">This project is the ideal base for PHP auth prototypes, demos, and lightweight production sites.</p>
                            <div class="row text-center mt-4">
                                <div class="col-6 border-end">
                                    <h3 class="mb-1">2</h3>
                                    <p class="text-muted mb-0">Pages</p>
                                </div>
                                <div class="col-6">
                                    <h3 class="mb-1">1</h3>
                                    <p class="text-muted mb-0">Database</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="start" class="mt-5 pt-5 pb-5 text-center">
            <div class="card p-5 bg-white bg-opacity-90 text-dark">
                <h2 class="fw-bold">Ready to build secure auth?</h2>
                <p class="text-muted mb-4">Jump in with a login/register experience that’s already wired for PHP and Bootstrap.</p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a class="btn btn-primary btn-lg px-5" href="public/register.php">Start Registering</a>
                    <a class="btn btn-outline-secondary btn-lg px-5" href="public/login.php">View Login</a>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer text-center">
        <div class="container">
            <p class="mb-1">Simple Auth Template • lightweight PHP auth starter</p>
            <p class="small">Built for fast onboarding and open contribution.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoFhV8u6F8U5bbw7T2LW8rFm4E6UiP6J2Vu3Qf2X4tMIm9A" crossorigin="anonymous"></script>
</body>
</html>
