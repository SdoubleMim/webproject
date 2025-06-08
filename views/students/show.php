<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">Student Profile</h1>
        <div>
            <a href="<?= getBaseUrl() ?>/students" class="btn btn-outline-primary me-2">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
            <a href="<?= getBaseUrl() ?>/students/edit/<?= $student['id'] ?>" class="btn btn-primary">
                <i class="bi bi-pencil"></i> Edit Profile
            </a>
        </div>
    </div>

    <?php if ($flash = getFlash()): ?>
        <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show" role="alert">
            <?= e($flash['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Personal Information -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 text-center">
                        <div class="avatar-placeholder mb-3">
                            <i class="bi bi-person-circle display-1"></i>
                        </div>
                        <h4><?= e($student['first_name'] . ' ' . $student['last_name']) ?></h4>
                        <p class="text-muted mb-0">Student ID: <?= e($student['student_id']) ?></p>
                    </div>
                    <hr>
                    <div class="mb-2">
                        <strong><i class="bi bi-envelope me-2"></i>Email:</strong>
                        <p class="text-muted mb-2"><?= e($student['email']) ?></p>
                    </div>
                    <div class="mb-2">
                        <strong><i class="bi bi-telephone me-2"></i>Phone:</strong>
                        <p class="text-muted mb-2"><?= e($student['phone'] ?? 'N/A') ?></p>
                    </div>
                    <div class="mb-2">
                        <strong><i class="bi bi-geo-alt me-2"></i>Address:</strong>
                        <p class="text-muted mb-0"><?= e($student['address'] ?? 'N/A') ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enrolled Courses -->
        <div class="col-md-8 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Enrolled Courses</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($enrolledCourses)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Code</th>
                                        <th>Schedule</th>
                                        <th>Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($enrolledCourses as $course): ?>
                                        <tr>
                                            <td>
                                                <a href="<?= getBaseUrl() ?>/courses/show/<?= $course['id'] ?>" 
                                                   class="text-decoration-none">
                                                    <?= e($course['name']) ?>
                                                </a>
                                            </td>
                                            <td><?= e($course['code']) ?></td>
                                            <td><?= e($course['schedule']) ?></td>
                                            <td>
                                                <?php 
                                                    $grade = $grades[$course['id']] ?? null;
                                                    if ($grade !== null) {
                                                        echo "<span class='badge bg-" . ($grade >= 75 ? 'success' : 'danger') . "'>{$grade}</span>";
                                                    } else {
                                                        echo "<span class='badge bg-secondary'>N/A</span>";
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-center text-muted my-4">No courses enrolled yet</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Schedule -->
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Weekly Schedule</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($schedule)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>Monday</th>
                                        <th>Tuesday</th>
                                        <th>Wednesday</th>
                                        <th>Thursday</th>
                                        <th>Friday</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($schedule as $time => $days): ?>
                                        <tr>
                                            <td><?= e($time) ?></td>
                                            <?php foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day): ?>
                                                <td>
                                                    <?php if (isset($days[$day])): ?>
                                                        <div class="course-schedule">
                                                            <strong><?= e($days[$day]['code']) ?></strong><br>
                                                            <small><?= e($days[$day]['name']) ?></small>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-center text-muted my-4">No schedule available</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-placeholder {
    width: 100px;
    height: 100px;
    margin: 0 auto;
    color: var(--bs-primary);
}

.course-schedule {
    padding: 5px;
    border-radius: 4px;
    background: rgba(157, 78, 221, 0.1);
}
</style>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 