<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-0">Available Courses</h2>
            <p class="text-muted">Browse and enroll in available courses</p>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search courses...">
                <button class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Course Categories -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-primary active">All</button>
                <button type="button" class="btn btn-primary">Computer Science</button>
                <button type="button" class="btn btn-primary">Mathematics</button>
                <button type="button" class="btn btn-primary">Physics</button>
                <button type="button" class="btn btn-primary">Languages</button>
            </div>
        </div>
    </div>

    <!-- Course Grid -->
    <div class="row g-4">
        <!-- Sample Course Cards -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-primary">Computer Science</span>
                        <small class="text-muted">3 Credits</small>
                    </div>
                    <h4 class="card-title h5">Introduction to Programming</h4>
                    <p class="card-text text-muted">Learn the fundamentals of programming with Python. Perfect for beginners.</p>
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="bi bi-calendar3 me-2"></i>Mon, Wed, Fri
                        </small>
                        <br>
                        <small class="text-muted">
                            <i class="bi bi-clock me-2"></i>9:00 AM - 10:30 AM
                        </small>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Enroll Now
                        </button>
                        <button class="btn btn-outline-light">
                            <i class="bi bi-info-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-primary">Mathematics</span>
                        <small class="text-muted">4 Credits</small>
                    </div>
                    <h4 class="card-title h5">Calculus I</h4>
                    <p class="card-text text-muted">Comprehensive introduction to differential and integral calculus.</p>
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="bi bi-calendar3 me-2"></i>Tue, Thu
                        </small>
                        <br>
                        <small class="text-muted">
                            <i class="bi bi-clock me-2"></i>11:00 AM - 12:30 PM
                        </small>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Enroll Now
                        </button>
                        <button class="btn btn-outline-light">
                            <i class="bi bi-info-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-primary">Physics</span>
                        <small class="text-muted">4 Credits</small>
                    </div>
                    <h4 class="card-title h5">Physics for Engineers</h4>
                    <p class="card-text text-muted">Study mechanics, waves, and thermodynamics with practical applications.</p>
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="bi bi-calendar3 me-2"></i>Mon, Wed, Fri
                        </small>
                        <br>
                        <small class="text-muted">
                            <i class="bi bi-clock me-2"></i>2:00 PM - 3:30 PM
                        </small>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Enroll Now
                        </button>
                        <button class="btn btn-outline-light">
                            <i class="bi bi-info-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="row mt-4">
        <div class="col-12">
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?> 