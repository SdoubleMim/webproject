<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Profile Settings</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $_SESSION['success'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $_SESSION['error'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <!-- User Info -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">User Information</h6>
                        <p><strong>Username:</strong> <?= e($user['username']) ?></p>
                        <p><strong>Email:</strong> <?= e($user['email']) ?></p>
                        <?php if (isset($student)): ?>
                            <p><strong>Student ID:</strong> <?= e($student['student_id']) ?></p>
                            <p><strong>Name:</strong> <?= e($student['first_name']) ?> <?= e($student['last_name']) ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Change Password Form -->
                    <div class="mt-4">
                        <h6 class="text-muted mb-3">Change Password</h6>
                        <form action="/webproject/profile/change-password" method="POST" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                                <div class="invalid-feedback">
                                    Please enter your current password.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required 
                                       minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                                <div class="invalid-feedback">
                                    Password must be at least 8 characters long and include uppercase, lowercase, and numbers.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                <div class="invalid-feedback">
                                    Please confirm your new password.
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </form>
                    </div>
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
            
            // Check if passwords match
            var newPassword = document.getElementById('new_password')
            var confirmPassword = document.getElementById('confirm_password')
            if (newPassword.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity('Passwords do not match')
                event.preventDefault()
                event.stopPropagation()
            } else {
                confirmPassword.setCustomValidity('')
            }
            
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 