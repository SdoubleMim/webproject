<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="container">
    <!-- Hero Section -->
    <div class="row justify-content-center align-items-center min-vh-75 py-5">
        <div class="col-md-8 text-center">
            <h1 class="display-4 mb-4 fw-bold">
                <span class="text-primary">Student</span> Management System
            </h1>
            <p class="lead mb-4 text-light">A comprehensive platform for managing your academic journey with ease and efficiency.</p>
            
            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                <a href="/webproject/register" class="btn btn-primary btn-lg px-4 gap-3">
                    <i class="bi bi-person-plus"></i> Get Started
                </a>
                <a href="/webproject/login" class="btn btn-outline-light btn-lg px-4">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="row mt-5 g-4">
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-primary">
                <div class="card-body text-center">
                    <div class="display-5 text-primary mb-3">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <h3 class="card-title h4">Course Management</h3>
                    <p class="card-text text-muted">Browse and manage your course enrollments with ease.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-primary">
                <div class="card-body text-center">
                    <div class="display-5 text-primary mb-3">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <h3 class="card-title h4">Grade Tracking</h3>
                    <p class="card-text text-muted">Monitor your academic performance and progress.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-primary">
                <div class="card-body text-center">
                    <div class="display-5 text-primary mb-3">
                        <i class="bi bi-calendar3-week"></i>
                    </div>
                    <h3 class="card-title h4">Class Schedule</h3>
                    <p class="card-text text-muted">Keep track of your classes and important dates.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-primary">
                <div class="card-body text-center">
                    <div class="display-5 text-primary mb-3">
                        <i class="bi bi-bell"></i>
                    </div>
                    <h3 class="card-title h4">Notifications</h3>
                    <p class="card-text text-muted">Stay updated with important announcements.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links Section -->
    <div class="row mt-5 mb-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-primary mb-4">Quick Links</h3>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <h4 class="h5 mb-3">For Students</h4>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <a href="/webproject/courses" class="text-decoration-none text-light">
                                        <i class="bi bi-arrow-right text-primary"></i> View Courses
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="/webproject/grades" class="text-decoration-none text-light">
                                        <i class="bi bi-arrow-right text-primary"></i> Check Grades
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="/webproject/schedule" class="text-decoration-none text-light">
                                        <i class="bi bi-arrow-right text-primary"></i> Class Schedule
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h4 class="h5 mb-3">Resources</h4>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <a href="/webproject/help" class="text-decoration-none text-light">
                                        <i class="bi bi-arrow-right text-primary"></i> Help Center
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="/webproject/faq" class="text-decoration-none text-light">
                                        <i class="bi bi-arrow-right text-primary"></i> FAQ
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="/webproject/contact" class="text-decoration-none text-light">
                                        <i class="bi bi-arrow-right text-primary"></i> Contact Support
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h4 class="h5 mb-3">Account</h4>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <a href="/webproject/profile" class="text-decoration-none text-light">
                                        <i class="bi bi-arrow-right text-primary"></i> Profile Settings
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="/webproject/notifications" class="text-decoration-none text-light">
                                        <i class="bi bi-arrow-right text-primary"></i> Notifications
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="/webproject/security" class="text-decoration-none text-light">
                                        <i class="bi bi-arrow-right text-primary"></i> Security
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?> 