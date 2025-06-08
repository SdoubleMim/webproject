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
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-book text-primary mb-3" style="font-size: 2rem;"></i>
                    <h5 class="card-title">Enrolled Courses</h5>
                    <h3 class="card-text"><?= count($enrolledCourses) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-graph-up text-primary mb-3" style="font-size: 2rem;"></i>
                    <h5 class="card-title">Average Grade</h5>
                    <h3 class="card-text">
                        <?php
                        $total = 0;
                        $count = count($grades);
                        foreach ($grades as $grade) {
                            $total += $grade['grade'];
                        }
                        echo $count > 0 ? number_format($total / $count, 2) : 'N/A';
                        ?>
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
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
                    <a href="/webproject/courses" class="btn btn-primary btn-sm">Browse Courses</a>
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
                                        <th>Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($enrolledCourses as $course): ?>
                                        <tr>
                                            <td><?= e($course['course_code']) ?></td>
                                            <td>
                                                <a href="/webproject/courses/show/<?= e($course['id']) ?>" class="text-decoration-none">
                                                    <?= e($course['course_name']) ?>
                                                </a>
                                            </td>
                                            <td><?= e($course['instructor_name']) ?></td>
                                            <td><?= e($course['schedule_days']) ?> <?= e($course['schedule_time']) ?></td>
                                            <td>
                                                <?php
                                                $courseGrade = array_filter($grades, function($g) use ($course) {
                                                    return $g['course_id'] === $course['id'];
                                                });
                                                echo !empty($courseGrade) ? reset($courseGrade)['grade'] : 'N/A';
                                                ?>
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

    <!-- Schedule -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Upcoming Schedule</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($schedule)): ?>
                        <p class="text-center text-muted">No upcoming classes scheduled.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Day</th>
                                        <th>Time</th>
                                        <th>Room</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($schedule as $class): ?>
                                        <tr>
                                            <td><?= e($class['course_name']) ?></td>
                                            <td><?= e($class['schedule_days']) ?></td>
                                            <td><?= e($class['schedule_time']) ?></td>
                                            <td><?= e($class['room']) ?></td>
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