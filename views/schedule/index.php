<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">Class Schedule</h2>
                </div>
                <div class="card-body">
                    <?php if (empty($scheduleByDay) || count(array_filter($scheduleByDay)) === 0): ?>
                        <div class="alert alert-info" role="alert">
                            You have no scheduled classes.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="12%">Time</th>
                                        <th>Monday</th>
                                        <th>Tuesday</th>
                                        <th>Wednesday</th>
                                        <th>Thursday</th>
                                        <th>Friday</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    // Define time slots with their variations
                                    $timeSlots = [
                                        '08:00-10:00' => [
                                            '8:00-10:00', '08:00-10:00', '8.00-10.00', '08.00-10.00',
                                            '8:00-10', '08:00-10', '9:00-10:30', '09:00-10:30'
                                        ],
                                        '10:00-12:00' => [
                                            '10:00-12:00', '10.00-12.00', '10:00-12', 
                                            '11:00-12:30', '11.00-12.30'
                                        ],
                                        '14:00-16:00' => [
                                            '14:00-16:00', '14.00-16.00', '2:00-4:00', '14:00-4:00',
                                            '13:00-14:30', '13.00-14.30', '1:00-2:30', '13:00-2:30'
                                        ],
                                        '16:00-18:00' => [
                                            '16:00-18:00', '16.00-18.00', '4:00-6:00', '16:00-6:00'
                                        ]
                                    ];
                                    
                                    foreach ($timeSlots as $displayTime => $variations): 
                                    ?>
                                        <tr>
                                            <td class="font-weight-bold text-center align-middle">
                                                <?= e($displayTime) ?>
                                            </td>
                                            <?php foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day): ?>
                                                <td class="align-middle">
                                                    <?php
                                                    if (isset($scheduleByDay[$day])) {
                                                        foreach ($scheduleByDay[$day] as $class) {
                                                            $classTime = trim($class['schedule_time']);
                                                            if (in_array($classTime, $variations)) {
                                                                ?>
                                                                <div class="class-block">
                                                                    <div class="course-code"><?= e($class['code']) ?></div>
                                                                    <div class="course-name"><?= e($class['name']) ?></div>
                                                                    <div class="course-instructor"><?= e($class['instructor_name']) ?></div>
                                                                    <div class="course-room">Room <?= e($class['room']) ?></div>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                            <?php endforeach; ?>
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

<style>
.class-block {
    padding: 10px;
    margin: 5px 0;
    background-color: #f8f9fa;
    border-radius: 6px;
    border-left: 4px solid #6f42c1;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.course-code {
    font-weight: bold;
    color: #6f42c1;
    font-size: 1.1em;
}

.course-name {
    color: #495057;
    margin: 4px 0;
}

.course-instructor, .course-room {
    color: #6c757d;
    font-size: 0.9em;
}

.thead-dark th {
    background-color: #343a40;
    color: white;
}

.table td {
    padding: 0.5rem;
}

.table th {
    text-align: center;
}
</style>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
