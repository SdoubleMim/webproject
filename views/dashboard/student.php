<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container py-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Welcome, <?= e($student['first_name']) ?> <?= e($student['last_name']) ?></h2>
                    <p class="card-text">Student ID: <?= e($student['student_id']) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-book text-primary mb-3" style="font-size: 2rem;"></i>
                    <h5 class="card-title">Enrolled Courses</h5>
                    <h3 class="card-text"><?= count($enrolledCourses) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-calendar3 text-primary mb-3" style="font-size: 2rem;"></i>
                    <h5 class="card-title">Upcoming Classes</h5>
                    <h3 class="card-text"><?= count($schedule) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Courses -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Current Courses</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($enrolledCourses)): ?>
                        <p class="text-center text-muted">You are not enrolled in any courses yet.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Course Code</th>
                                        <th>Course Name</th>
                                        <th>Instructor</th>
                                        <th>Schedule</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($enrolledCourses as $course): ?>
                                        <tr>
                                            <td><?= e($course['course_code']) ?></td>
                                            <td><?= e($course['course_name']) ?></td>
                                            <td><?= e($course['instructor_name']) ?></td>
                                            <td><?= e($course['schedule_days']) ?> <?= e($course['schedule_time']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 