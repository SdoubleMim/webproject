<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Grade Report</h2>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h4>Overall GPA: <?= number_format($gpa, 2) ?></h4>
                    </div>
                    
                    <?php if (empty($enrolledCourses)): ?>
                        <div class="alert" role="alert">
                            You are not enrolled in any courses.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Course Code</th>
                                        <th>Course Name</th>
                                        <th>Credits</th>
                                        <th>Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($enrolledCourses as $course): ?>
                                        <tr>
                                            <td><?= e($course['course_code']) ?></td>
                                            <td><?= e($course['course_name']) ?></td>
                                            <td><?= e($course['credits']) ?></td>
                                            <td><?= isset($course['grade']) ? e($course['grade']) : 'N/A' ?></td>
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
