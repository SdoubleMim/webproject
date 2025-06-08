<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Class Schedule</h2>
                </div>
                <div class="card-body">
                    <?php if (empty($scheduleByDay)): ?>
                        <div class="alert" role="alert">
                            You have no scheduled classes.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table">
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
                                    <?php
                                    // Get all unique time slots
                                    $timeSlots = [];
                                    foreach ($scheduleByDay as $dayClasses) {
                                        foreach ($dayClasses as $class) {
                                            $timeSlots[$class['schedule_time']] = true;
                                        }
                                    }
                                    ksort($timeSlots); // Sort time slots

                                    // For each time slot, show classes for each day
                                    foreach (array_keys($timeSlots) as $time):
                                    ?>
                                        <tr>
                                            <td><?= e($time) ?></td>
                                            <?php
                                            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                                            foreach ($days as $day):
                                                echo '<td>';
                                                if (isset($scheduleByDay[$day])) {
                                                    foreach ($scheduleByDay[$day] as $class) {
                                                        if ($class['schedule_time'] === $time) {
                                                            echo '<strong>' . e($class['course_code']) . '</strong><br>';
                                                            echo e($class['course_name']) . '<br>';
                                                            echo '<small>Prof. ' . e($class['instructor_name']) . '<br>';
                                                            echo 'Room ' . e($class['room']) . '</small>';
                                                        }
                                                    }
                                                }
                                                echo '</td>';
                                            endforeach;
                                            ?>
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
