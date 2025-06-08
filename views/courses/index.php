<?php 
require_once __DIR__ . '/../layouts/header.php';
$baseUrl = getBaseUrl();
?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="text-light">Available Courses</h2>
    </div>
    <div class="col-md-4">
        <form action="<?= $baseUrl ?>/courses" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search courses..." value="<?= htmlspecialchars($search ?? '') ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>
</div>

<?php if (empty($courses)): ?>
    <div class="alert" role="alert">
        No courses found.
    </div>
<?php else: ?>
    <div class="row">
        <?php foreach ($courses as $course): ?>
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($course['course_code']) ?> - <?= htmlspecialchars($course['course_name']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($course['description']) ?></p>
                        <div class="mb-2">
                            <small class="text-light">
                                <strong>Instructor:</strong> <?= htmlspecialchars($course['instructor_name']) ?>
                            </small>
                        </div>
                        <div class="mb-2">
                            <small class="text-light">
                                <strong>Schedule:</strong> 
                                <?= htmlspecialchars($course['schedule_days']) ?> at <?= htmlspecialchars($course['schedule_time']) ?>
                            </small>
                        </div>
                        <div class="mb-3">
                            <small class="text-light">
                                <strong>Credits:</strong> <?= htmlspecialchars($course['credits']) ?>
                            </small>
                        </div>
                        <div class="d-flex justify-content-end">
                            <?php if (isset($enrolledIds) && !in_array($course['id'], $enrolledIds)): ?>
                                <form action="<?= $baseUrl ?>/courses/enroll/<?= $course['id'] ?>" method="POST" class="d-inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-outline-primary">Enroll</button>
                                </form>
                            <?php elseif (isset($enrolledIds) && in_array($course['id'], $enrolledIds)): ?>
                                <form action="<?= $baseUrl ?>/courses/drop/<?= $course['id'] ?>" method="POST" class="d-inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-outline-danger">Drop</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (isAdmin()): ?>
    <div class="fixed-bottom mb-4 me-4" style="right: 0;">
        <a href="<?= $baseUrl ?>/courses/create" class="btn btn-lg btn-primary rounded-circle" style="width: 60px; height: 60px;">
            <span style="font-size: 24px;">+</span>
        </a>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 