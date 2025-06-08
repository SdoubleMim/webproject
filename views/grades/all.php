<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Manage Student Grades</h2>
                </div>
                <div class="card-body">
                    <?php if (empty($enrollments)): ?>
                        <div class="alert" role="alert">
                            No enrollments found.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Course</th>
                                        <th>Current Grade</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($enrollments as $enrollment): ?>
                                        <tr>
                                            <td><?= e($enrollment['student_name']) ?></td>
                                            <td><?= e($enrollment['course_code']) ?> - <?= e($enrollment['course_name']) ?></td>
                                            <td><?= isset($enrollment['grade']) ? number_format($enrollment['grade'], 2) : 'Not set' ?></td>
                                            <td>
                                                <form action="<?= getBaseUrl() ?>/grades/update" method="POST" class="d-flex align-items-center">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="student_id" value="<?= e($enrollment['student_id']) ?>">
                                                    <input type="hidden" name="course_id" value="<?= e($enrollment['course_id']) ?>">
                                                    <input type="number" name="grade" step="0.1" min="0" max="20" class="form-control form-control-sm me-2" style="width: 80px;" value="<?= e($enrollment['grade'] ?? '') ?>" required>
                                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                                </form>
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

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 