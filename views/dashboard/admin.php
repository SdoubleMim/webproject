<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container py-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Admin Dashboard</h2>
                    <p class="card-text">Manage courses, students, and view system statistics.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-4">
            <a href="<?= getBaseUrl() ?>/courses/create" class="text-decoration-none">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-plus-circle text-primary mb-3" style="font-size: 2rem;"></i>
                        <h5 class="card-title">Create Course</h5>
                        <p class="card-text">Add a new course to the system</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="<?= getBaseUrl() ?>/courses" class="text-decoration-none">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-book text-primary mb-3" style="font-size: 2rem;"></i>
                        <h5 class="card-title">Manage Courses</h5>
                        <p class="card-text">View and edit existing courses</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="<?= getBaseUrl() ?>/students" class="text-decoration-none">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-people text-primary mb-3" style="font-size: 2rem;"></i>
                        <h5 class="card-title">Manage Students</h5>
                        <p class="card-text">View and manage student records</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">System Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3 text-center">
                                <h6 class="text-muted mb-1">Total Students</h6>
                                <h3 class="mb-0"><?= e($totalStudents ?? 0) ?></h3>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3 text-center">
                                <h6 class="text-muted mb-1">Total Courses</h6>
                                <h3 class="mb-0"><?= e($totalCourses ?? 0) ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($recentEnrollments)): ?>
                        <p class="text-center text-muted">No recent enrollments.</p>
                    <?php else: ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($recentEnrollments as $enrollment): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><?= e($enrollment['student_name']) ?></strong>
                                        enrolled in
                                        <strong><?= e($enrollment['course_name']) ?></strong>
                                    </div>
                                    <small class="text-muted">
                                        <?= formatDate($enrollment['enrollment_date']) ?>
                                    </small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Management -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Course Overview</h5>
                    <a href="<?= getBaseUrl() ?>/courses" class="btn btn-primary btn-sm">View All</a>
                </div>
                <div class="card-body">
                    <?php if (empty($courses)): ?>
                        <p class="text-center text-muted">No courses available.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Course Code</th>
                                        <th>Course Name</th>
                                        <th>Instructor</th>
                                        <th>Enrolled</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (array_slice($courses, 0, 5) as $course): ?>
                                        <tr>
                                            <td><?= e($course['course_code']) ?></td>
                                            <td><?= e($course['course_name']) ?></td>
                                            <td><?= e($course['instructor_name']) ?></td>
                                            <td>
                                                <?= e($course['enrolled_count']) ?> / <?= e($course['max_students']) ?>
                                            </td>
                                            <td>
                                                <a href="<?= getBaseUrl() ?>/courses/edit/<?= e($course['id']) ?>" class="btn btn-sm btn-outline-primary me-1">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                        onclick="confirmDelete(<?= e($course['id']) ?>)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
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

<script>
function confirmDelete(courseId) {
    if (confirm('Are you sure you want to delete this course?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `<?= getBaseUrl() ?>/courses/delete/${courseId}`;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 