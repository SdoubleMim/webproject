<?php
$user = $_SESSION['user'] ?? null;
$isLoggedIn = isset($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? e($title) : 'Student Management System' ?></title>
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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

        .table {
            color: var(--dark-text);
        }

        .table thead th {
            background-color: var(--dark-secondary);
            border-color: var(--border-color);
        }

        .table td {
            border-color: var(--border-color);
        }

        .form-control, .form-select {
            background-color: var(--dark-secondary);
            border-color: var(--border-color);
            color: var(--dark-text);
        }

        .form-control:focus, .form-select:focus {
            background-color: var(--dark-secondary);
            border-color: var(--accent-color);
            color: var(--dark-text);
            box-shadow: 0 0 0 0.25rem rgba(139, 92, 246, 0.25);
        }

        .main-content {
            flex: 1;
            padding: 2rem 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= getBaseUrl() ?>">SMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= getBaseUrl() ?>">Home</a>
                    </li>
                    <?php if ($isLoggedIn): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= getBaseUrl() ?>/dashboard">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= getBaseUrl() ?>/students">Students</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav">
                    <?php if ($isLoggedIn): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= getBaseUrl() ?>/auth/logout">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= getBaseUrl() ?>/auth/login">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="main-content">
        <div class="container"><?php if (isset($flash_message)): ?>
            <div class="alert alert-<?= $flash_message['type'] ?> alert-dismissible fade show" role="alert">
                <?= $flash_message['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?> 