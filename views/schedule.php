<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-0">Class Schedule</h2>
            <p class="text-muted">View your weekly class schedule</p>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="btn-group">
                <button type="button" class="btn btn-primary active">Week</button>
                <button type="button" class="btn btn-primary">Month</button>
            </div>
        </div>
    </div>

    <!-- Schedule Calendar -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 100px;">Time</th>
                            <th>Monday</th>
                            <th>Tuesday</th>
                            <th>Wednesday</th>
                            <th>Thursday</th>
                            <th>Friday</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- 9:00 AM -->
                        <tr>
                            <td class="text-center">9:00 AM</td>
                            <td class="bg-primary bg-opacity-25">
                                <div class="p-2">
                                    <h6 class="mb-1">Introduction to Programming</h6>
                                    <small class="text-muted">CS101 • Room 301</small>
                                </div>
                            </td>
                            <td></td>
                            <td class="bg-primary bg-opacity-25">
                                <div class="p-2">
                                    <h6 class="mb-1">Introduction to Programming</h6>
                                    <small class="text-muted">CS101 • Room 301</small>
                                </div>
                            </td>
                            <td></td>
                            <td class="bg-primary bg-opacity-25">
                                <div class="p-2">
                                    <h6 class="mb-1">Introduction to Programming</h6>
                                    <small class="text-muted">CS101 • Room 301</small>
                                </div>
                            </td>
                        </tr>
                        <!-- 11:00 AM -->
                        <tr>
                            <td class="text-center">11:00 AM</td>
                            <td></td>
                            <td class="bg-primary bg-opacity-25">
                                <div class="p-2">
                                    <h6 class="mb-1">Calculus I</h6>
                                    <small class="text-muted">MATH201 • Room 205</small>
                                </div>
                            </td>
                            <td></td>
                            <td class="bg-primary bg-opacity-25">
                                <div class="p-2">
                                    <h6 class="mb-1">Calculus I</h6>
                                    <small class="text-muted">MATH201 • Room 205</small>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <!-- 2:00 PM -->
                        <tr>
                            <td class="text-center">2:00 PM</td>
                            <td class="bg-primary bg-opacity-25">
                                <div class="p-2">
                                    <h6 class="mb-1">Physics for Engineers</h6>
                                    <small class="text-muted">PHY301 • Room 405</small>
                                </div>
                            </td>
                            <td></td>
                            <td class="bg-primary bg-opacity-25">
                                <div class="p-2">
                                    <h6 class="mb-1">Physics for Engineers</h6>
                                    <small class="text-muted">PHY301 • Room 405</small>
                                </div>
                            </td>
                            <td></td>
                            <td class="bg-primary bg-opacity-25">
                                <div class="p-2">
                                    <h6 class="mb-1">Physics for Engineers</h6>
                                    <small class="text-muted">PHY301 • Room 405</small>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-calendar-check text-primary me-2"></i>
                        Upcoming Events
                    </h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <span class="badge bg-primary">Mar 15</span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Midterm Exam</h6>
                                    <small class="text-muted">Physics for Engineers</small>
                                </div>
                            </div>
                        </li>
                        <li class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <span class="badge bg-primary">Mar 17</span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Project Due</h6>
                                    <small class="text-muted">Introduction to Programming</small>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <span class="badge bg-primary">Mar 20</span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Quiz</h6>
                                    <small class="text-muted">Calculus I</small>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-book text-primary me-2"></i>
                        Study Groups
                    </h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <span class="badge bg-primary">Mon</span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Programming Lab</h6>
                                    <small class="text-muted">4:00 PM • Library</small>
                                </div>
                            </div>
                        </li>
                        <li class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <span class="badge bg-primary">Wed</span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Math Study Group</h6>
                                    <small class="text-muted">5:00 PM • Room 202</small>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <span class="badge bg-primary">Thu</span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Physics Review</h6>
                                    <small class="text-muted">3:00 PM • Lab 405</small>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-gear text-primary me-2"></i>
                        Quick Actions
                    </h5>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>
                            Add Event
                        </button>
                        <button class="btn btn-outline-light">
                            <i class="bi bi-calendar-plus me-2"></i>
                            Schedule Study Group
                        </button>
                        <button class="btn btn-outline-light">
                            <i class="bi bi-share me-2"></i>
                            Share Schedule
                        </button>
                        <button class="btn btn-outline-light">
                            <i class="bi bi-printer me-2"></i>
                            Print Schedule
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?> 