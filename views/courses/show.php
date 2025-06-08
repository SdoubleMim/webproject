<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title mb-4"><?= htmlspecialchars($course['code']) ?> - <?= htmlspecialchars($course['name']) ?></h2>
                
                <div class="mb-4">
                    <h5 class="text-light">Description</h5>
                    <p><?= htmlspecialchars($course['description']) ?></p>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="text-light">Course Details</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <strong>Credits:</strong> <?= htmlspecialchars($course['credits']) ?>
                            </li>
                            <li class="mb-2">
                                <strong>Instructor:</strong> <?= htmlspecialchars($course['instructor_name']) ?>
                            </li>
                            <li class="mb-2">
                                <strong>Room:</strong> <?= htmlspecialchars($course['room']) ?>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-light">Schedule</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <strong>Days:</strong> <?= htmlspecialchars($course['schedule_days']) ?>
                            </li>
                            <li class="mb-2">
                                <strong>Time:</strong> <?= htmlspecialchars($course['schedule_time']) ?>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <a href="/courses" class="btn btn-outline-primary">Back to Courses</a>
                    
                    <div>
                        <?php if (!$isEnrolled): ?>
                            <form action="/courses/enroll" method="POST" class="d-inline">
                                <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                <button type="submit" class="btn btn-primary">Enroll</button>
                            </form>
                        <?php else: ?>
                            <form action="/courses/drop" method="POST" class="d-inline">
                                <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                <button type="submit" class="btn btn-danger">Drop Course</button>
                            </form>
                        <?php endif; ?>

                        <?php if (isAdmin()): ?>
                            <a href="/courses/<?= $course['id'] ?>/edit" class="btn btn-primary ms-2">Edit Course</a>
                            <form action="/courses/<?= $course['id'] ?>/delete" method="POST" class="d-inline ms-2" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                <button type="submit" class="btn btn-danger">Delete Course</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 