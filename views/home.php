<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --dark-bg: #1a1a1a;
            --dark-text: #ffffff;
            --dark-secondary: #2d2d2d;
            --accent-color: #8b5cf6;
            --accent-hover: #7c3aed;
            --accent-light: rgba(139, 92, 246, 0.1);
            --border-color: #404040;
        }

        body {
            background-color: var(--dark-bg);
            color: var(--dark-text);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: var(--dark-secondary) !important;
            border-bottom: 1px solid var(--border-color);
        }

        .card {
            background-color: var(--dark-secondary);
            border: 1px solid var(--border-color);
            transition: transform 0.2s, border-color 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            border-color: var(--accent-color);
        }

        .btn-primary {
            background-color: var(--accent-color) !important;
            border-color: var(--accent-color) !important;
        }

        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active {
            background-color: var(--accent-hover) !important;
            border-color: var(--accent-hover) !important;
        }

        .btn-outline-light {
            color: var(--dark-text);
            border-color: var(--border-color);
        }

        .btn-outline-light:hover,
        .btn-outline-light:focus {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: var(--dark-text);
        }

        .feature-icon {
            font-size: 2rem;
            color: var(--accent-color);
            margin-bottom: 1rem;
        }

        .hero-section {
            min-height: 80vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 6rem 0;
            background: linear-gradient(135deg, rgba(18, 18, 18, 0.95) 0%, rgba(45, 27, 77, 0.95) 100%),
                        url('https://source.unsplash.com/random/1920x1080/?university') no-repeat center center;
            background-size: cover;
            background-attachment: fixed;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at center, rgba(157, 78, 221, 0.1) 0%, transparent 70%);
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 2rem;
            background: linear-gradient(135deg, #ffffff 0%, #c77dff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 30px rgba(157, 78, 221, 0.3);
        }

        .hero-description {
            font-size: 1.5rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 3rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .features-section {
            padding: 6rem 0;
            background: linear-gradient(135deg, #121212 0%, #1a1a1a 100%);
            position: relative;
            overflow: hidden;
        }

        .features-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(157, 78, 221, 0.5), transparent);
        }

        .feature-card {
            height: 100%;
            padding: 2rem;
            text-align: center;
            background: linear-gradient(145deg, rgba(31, 31, 31, 0.6), rgba(45, 27, 77, 0.6));
            border: 1px solid rgba(157, 78, 221, 0.2);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(157, 78, 221, 0.3);
            border-color: rgba(157, 78, 221, 0.4);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #9d4edd 0%, #c77dff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 10px rgba(157, 78, 221, 0.3));
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #ffffff 0%, #c77dff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .feature-description {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .cta-buttons {
            gap: 1rem;
        }

        .cta-buttons .btn {
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 500;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-get-started {
            background: linear-gradient(135deg, #9d4edd 0%, #7b2cbf 100%);
            border: none;
            color: white;
            box-shadow: 0 4px 15px rgba(157, 78, 221, 0.3);
            transition: all 0.3s ease;
        }

        .btn-get-started:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(157, 78, 221, 0.4);
        }

        .btn-login {
            background: transparent;
            border: 2px solid rgba(157, 78, 221, 0.5);
            color: white;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: rgba(157, 78, 221, 0.1);
            border-color: rgba(157, 78, 221, 0.8);
            color: white;
            transform: translateY(-2px);
        }

        footer {
            background: linear-gradient(to right, #1f1f1f, #2d1b4d);
            padding: 2rem 0;
            position: relative;
            overflow: hidden;
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(157, 78, 221, 0.5), transparent);
        }

        .copyright {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= getBaseUrl() ?>">Student Management System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (auth()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= getBaseUrl() ?>/courses">Courses</a>
                        </li>
                        <?php if (isAdmin()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= getBaseUrl() ?>/courses/create">Create Course</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= getBaseUrl() ?>/logout">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= getBaseUrl() ?>/login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= getBaseUrl() ?>/register">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="container mt-3">
            <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show">
                <?= e($_SESSION['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container hero-content text-center">
            <h1 class="hero-title"><?= e($title) ?></h1>
            <p class="hero-description"><?= e($description) ?></p>
            <?php if (!auth()): ?>
                <div class="d-flex justify-content-center cta-buttons">
                    <a href="<?= getBaseUrl() ?>/register" class="btn btn-get-started">Get Started</a>
                    <a href="<?= getBaseUrl() ?>/login" class="btn btn-login">Login</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="row g-4">
                <?php foreach ($features as $title => $description): ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <?php
                                $icons = [
                                    'Course Management' => '<i class="bi bi-book"></i>',
                                    'Grade Tracking' => '<i class="bi bi-graph-up"></i>',
                                    'Schedule Planning' => '<i class="bi bi-calendar3"></i>',
                                    'Dark Theme' => '<i class="bi bi-moon-stars"></i>'
                                ];
                                echo $icons[$title] ?? '<i class="bi bi-star"></i>';
                                ?>
                            </div>
                            <h3 class="feature-title"><?= e($title) ?></h3>
                            <p class="feature-description"><?= e($description) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p class="copyright">&copy; <?= date('Y') ?> Student Management System. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 