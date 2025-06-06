<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-0"><?php echo isset($course) ? 'Edit Course' : 'Add New Course'; ?></h2>
            <p class="text-muted">
                <?php echo isset($course) ? 'Update course information' : 'Create a new course'; ?>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" class="needs-validation" novalidate>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code" class="form-label">Course Code</label>
                                    <input type="text" class="form-control" id="code" name="code" 
                                           value="<?php echo $course['code'] ?? ''; ?>" required>
                                    <div class="invalid-feedback">Please enter a course code.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Course Name</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="<?php echo $course['name'] ?? ''; ?>" required>
                                    <div class="invalid-feedback">Please enter a course name.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-select" id="category" name="category" required>
                                        <option value="">Select Category</option>
                                        <option value="Computer Science" <?php echo (isset($course) && $course['category'] == 'Computer Science') ? 'selected' : ''; ?>>Computer Science</option>
                                        <option value="Mathematics" <?php echo (isset($course) && $course['category'] == 'Mathematics') ? 'selected' : ''; ?>>Mathematics</option>
                                        <option value="Physics" <?php echo (isset($course) && $course['category'] == 'Physics') ? 'selected' : ''; ?>>Physics</option>
                                        <option value="Languages" <?php echo (isset($course) && $course['category'] == 'Languages') ? 'selected' : ''; ?>>Languages</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a category.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="credits" class="form-label">Credits</label>
                                    <input type="number" class="form-control" id="credits" name="credits" 
                                           value="<?php echo $course['credits'] ?? ''; ?>" required min="1" max="6">
                                    <div class="invalid-feedback">Please enter valid credits (1-6).</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="instructor_name" class="form-label">Instructor Name</label>
                                    <input type="text" class="form-control" id="instructor_name" name="instructor_name" 
                                           value="<?php echo $course['instructor_name'] ?? ''; ?>" required>
                                    <div class="invalid-feedback">Please enter instructor name.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="max_students" class="form-label">Maximum Students</label>
                                    <input type="number" class="form-control" id="max_students" name="max_students" 
                                           value="<?php echo $course['max_students'] ?? '30'; ?>" required min="1">
                                    <div class="invalid-feedback">Please enter maximum number of students.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="schedule_days" class="form-label">Schedule Days</label>
                                    <input type="text" class="form-control" id="schedule_days" name="schedule_days" 
                                           value="<?php echo $course['schedule_days'] ?? ''; ?>" 
                                           placeholder="e.g., Mon, Wed, Fri" required>
                                    <div class="invalid-feedback">Please enter schedule days.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="schedule_time" class="form-label">Schedule Time</label>
                                    <input type="text" class="form-control" id="schedule_time" name="schedule_time" 
                                           value="<?php echo $course['schedule_time'] ?? ''; ?>" 
                                           placeholder="e.g., 9:00 AM - 10:30 AM" required>
                                    <div class="invalid-feedback">Please enter schedule time.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="room" class="form-label">Room</label>
                                    <input type="text" class="form-control" id="room" name="room" 
                                           value="<?php echo $course['room'] ?? ''; ?>" required>
                                    <div class="invalid-feedback">Please enter room number.</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required><?php echo $course['description'] ?? ''; ?></textarea>
                            <div class="invalid-feedback">Please enter course description.</div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/webproject/courses" class="btn btn-outline-light">
                                <i class="bi bi-arrow-left me-2"></i>Back to Courses
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>
                                <?php echo isset($course) ? 'Update Course' : 'Create Course'; ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Form validation
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?> 