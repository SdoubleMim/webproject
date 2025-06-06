<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --bs-body-bg: #121212;
            --bs-body-color: #ffffff;
            --bs-primary: #9d4edd;
            --bs-primary-rgb: 157, 78, 221;
            --bs-primary-hover: #7b2cbf;
            --bs-secondary: #1f1f1f;
            --bs-link-color: #c77dff;
            --bs-link-hover-color: #e0aaff;
        }
        
        body {
            background: linear-gradient(135deg, #121212 0%, #1a1a1a 100%);
            min-height: 100vh;
        }
        
        .navbar {
            background: linear-gradient(to right, #1f1f1f, #2d1b4d) !important;
            border-bottom: 1px solid rgba(157, 78, 221, 0.2);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
        .card {
            background: linear-gradient(145deg, #1f1f1f, #2d1b4d);
            border: 1px solid rgba(157, 78, 221, 0.2);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(157, 78, 221, 0.2);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-primary-hover) 100%) !important;
            border: none !important;
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(157, 78, 221, 0.3);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active {
            background: linear-gradient(135deg, var(--bs-primary-hover) 0%, var(--bs-primary) 100%) !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(157, 78, 221, 0.4);
        }

        .btn-outline-primary {
            color: var(--bs-primary) !important;
            border: 2px solid var(--bs-primary) !important;
            background: transparent !important;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover,
        .btn-outline-primary:focus,
        .btn-outline-primary:active {
            color: #fff !important;
            background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-primary-hover) 100%) !important;
            border-color: transparent !important;
            transform: translateY(-2px);
        }
        
        .text-primary {
            color: var(--bs-primary) !important;
        }
        
        .bg-primary {
            background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-primary-hover) 100%) !important;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background: var(--bs-primary);
            transition: width 0.3s ease;
        }

        .nav-link:hover,
        .nav-link:focus {
            color: #ffffff !important;
        }

        .nav-link:hover:after,
        .nav-link:focus:after {
            width: 100%;
        }

        .dropdown-menu {
            background: linear-gradient(145deg, #1f1f1f, #2d1b4d);
            border: 1px solid rgba(157, 78, 221, 0.2);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .dropdown-item {
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-primary-hover) 100%) !important;
            color: #fff !important;
        }

        .page-link {
            color: var(--bs-link-color);
            background: linear-gradient(145deg, #1f1f1f, #2d1b4d);
            border: 1px solid rgba(157, 78, 221, 0.2);
            transition: all 0.3s ease;
        }

        .page-link:hover,
        .page-link:focus {
            color: #fff;
            background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-primary-hover) 100%);
            border-color: transparent;
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-primary-hover) 100%);
            border-color: transparent;
        }

        .badge.bg-primary {
            background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-primary-hover) 100%) !important;
        }

        .form-control {
            background: rgba(31, 31, 31, 0.8);
            border: 1px solid rgba(157, 78, 221, 0.2);
            color: #ffffff;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(31, 31, 31, 0.9);
            border-color: var(--bs-primary);
            box-shadow: 0 0 0 0.25rem rgba(157, 78, 221, 0.25);
            color: #ffffff;
        }

        .alert-primary {
            background: linear-gradient(135deg, rgba(157, 78, 221, 0.1) 0%, rgba(123, 44, 191, 0.1) 100%);
            border: 1px solid rgba(157, 78, 221, 0.2);
            color: #ffffff;
        }

        .dropdown-divider {
            border-color: rgba(157, 78, 221, 0.2);
        }

        /* Glow effect for icons */
        .bi {
            text-shadow: 0 0 10px rgba(157, 78, 221, 0.5);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #1f1f1f;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--bs-primary);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--bs-primary-hover);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/webproject">
                <i class="bi bi-mortarboard-fill text-primary"></i> 
                Student Management
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <?php if (auth()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/webproject/dashboard">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/webproject/courses">
                                <i class="bi bi-book"></i> Courses
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/webproject/grades">
                                <i class="bi bi-graph-up"></i> Grades
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/webproject/schedule">
                                <i class="bi bi-calendar3"></i> Schedule
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav">
                    <?php if (auth()): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> <?php echo auth()['username']; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="/webproject/profile">
                                    <i class="bi bi-person"></i> Profile
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/webproject/logout">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/webproject/login">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/webproject/register">
                                <i class="bi bi-person-plus"></i> Register
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="container">
            <div class="alert alert-<?php echo $_SESSION['message_type'] ?? 'info'; ?> alert-dismissible fade show">
                <?php 
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>
</body>
</html> 