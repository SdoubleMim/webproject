<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-0">My Grades</h2>
            <p class="text-muted">View your academic performance</p>
        </div>
        <div class="col-md-4 text-md-end">
            <select class="form-select">
                <option selected>Current Semester</option>
                <option>Fall 2023</option>
                <option>Spring 2023</option>
                <option>Fall 2022</option>
            </select>
        </div>
    </div>

    <!-- GPA Summary Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card bg-primary bg-gradient">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center text-md-start mb-3 mb-md-0">
                            <h4 class="text-white mb-0">Current GPA</h4>
                            <h2 class="display-4 text-white fw-bold mb-0">3.75</h2>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-6 col-md-3 text-center mb-3">
                                    <h5 class="text-white mb-1">Credits</h5>
                                    <p class="h4 text-white mb-0">45</p>
                                </div>
                                <div class="col-6 col-md-3 text-center mb-3">
                                    <h5 class="text-white mb-1">Courses</h5>
                                    <p class="h4 text-white mb-0">5</p>
                                </div>
                                <div class="col-6 col-md-3 text-center">
                                    <h5 class="text-white mb-1">Completed</h5>
                                    <p class="h4 text-white mb-0">15</p>
                                </div>
                                <div class="col-6 col-md-3 text-center">
                                    <h5 class="text-white mb-1">In Progress</h5>
                                    <p class="h4 text-white mb-0">3</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grades Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Credits</th>
                            <th>Assignments</th>
                            <th>Midterm</th>
                            <th>Final</th>
                            <th>Grade</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-primary me-2">CS</span>
                                    <div>
                                        <h6 class="mb-0">Introduction to Programming</h6>
                                        <small class="text-muted">CS101</small>
                                    </div>
                                </div>
                            </td>
                            <td>3</td>
                            <td>92%</td>
                            <td>88%</td>
                            <td>90%</td>
                            <td><span class="badge bg-success">A</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-light">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-primary me-2">MATH</span>
                                    <div>
                                        <h6 class="mb-0">Calculus I</h6>
                                        <small class="text-muted">MATH201</small>
                                    </div>
                                </div>
                            </td>
                            <td>4</td>
                            <td>85%</td>
                            <td>82%</td>
                            <td>88%</td>
                            <td><span class="badge bg-success">B+</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-light">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-primary me-2">PHY</span>
                                    <div>
                                        <h6 class="mb-0">Physics for Engineers</h6>
                                        <small class="text-muted">PHY301</small>
                                    </div>
                                </div>
                            </td>
                            <td>4</td>
                            <td>90%</td>
                            <td>87%</td>
                            <td>--</td>
                            <td><span class="badge bg-secondary">IP</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-light">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Grade Distribution Chart -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Grade Distribution</h5>
                    <div class="progress-stacked">
                        <div class="progress" role="progressbar" style="width: 35%">
                            <div class="progress-bar bg-success">A (35%)</div>
                        </div>
                        <div class="progress" role="progressbar" style="width: 25%">
                            <div class="progress-bar bg-primary">B (25%)</div>
                        </div>
                        <div class="progress" role="progressbar" style="width: 20%">
                            <div class="progress-bar bg-info">C (20%)</div>
                        </div>
                        <div class="progress" role="progressbar" style="width: 15%">
                            <div class="progress-bar bg-warning">D (15%)</div>
                        </div>
                        <div class="progress" role="progressbar" style="width: 5%">
                            <div class="progress-bar bg-danger">F (5%)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Academic Standing</h5>
                    <div class="alert alert-success mb-0">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        You are in good academic standing
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?> 