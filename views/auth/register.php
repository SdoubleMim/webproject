<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php if ($flash = getFlash()): ?>
                <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show" role="alert">
                    <?= e($flash['message']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Register</h4>
                </div>
                <div class="card-body">
                    <form action="<?= getBaseUrl() ?>/register" method="POST" class="needs-validation" novalidate>
                        <?= csrf_field() ?>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" 
                                       class="form-control <?= isset($_SESSION['errors']['username']) ? 'is-invalid' : '' ?>" 
                                       id="username" 
                                       name="username" 
                                       value="<?= old('username') ?>" 
                                       required>
                                <?php if (isset($_SESSION['errors']['username'])): ?>
                                    <div class="invalid-feedback">
                                        <?= e($_SESSION['errors']['username']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" 
                                       class="form-control <?= isset($_SESSION['errors']['email']) ? 'is-invalid' : '' ?>" 
                                       id="email" 
                                       name="email" 
                                       value="<?= old('email') ?>" 
                                       required>
                                <?php if (isset($_SESSION['errors']['email'])): ?>
                                    <div class="invalid-feedback">
                                        <?= e($_SESSION['errors']['email']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control <?= isset($_SESSION['errors']['password']) ? 'is-invalid' : '' ?>" 
                                           id="password" 
                                           name="password" 
                                           required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <?php if (isset($_SESSION['errors']['password'])): ?>
                                        <div class="invalid-feedback">
                                            <?= e($_SESSION['errors']['password']) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirm" class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control <?= isset($_SESSION['errors']['password_confirm']) ? 'is-invalid' : '' ?>" 
                                           id="password_confirm" 
                                           name="password_confirm" 
                                           required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <?php if (isset($_SESSION['errors']['password_confirm'])): ?>
                                        <div class="invalid-feedback">
                                            <?= e($_SESSION['errors']['password_confirm']) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" 
                                       class="form-control <?= isset($_SESSION['errors']['first_name']) ? 'is-invalid' : '' ?>" 
                                       id="first_name" 
                                       name="first_name" 
                                       value="<?= old('first_name') ?>" 
                                       required>
                                <?php if (isset($_SESSION['errors']['first_name'])): ?>
                                    <div class="invalid-feedback">
                                        <?= e($_SESSION['errors']['first_name']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" 
                                       class="form-control <?= isset($_SESSION['errors']['last_name']) ? 'is-invalid' : '' ?>" 
                                       id="last_name" 
                                       name="last_name" 
                                       value="<?= old('last_name') ?>" 
                                       required>
                                <?php if (isset($_SESSION['errors']['last_name'])): ?>
                                    <div class="invalid-feedback">
                                        <?= e($_SESSION['errors']['last_name']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="student_id" class="form-label">Student ID</label>
                                <input type="text" 
                                       class="form-control <?= isset($_SESSION['errors']['student_id']) ? 'is-invalid' : '' ?>" 
                                       id="student_id" 
                                       name="student_id" 
                                       value="<?= old('student_id') ?>" 
                                       required>
                                <?php if (isset($_SESSION['errors']['student_id'])): ?>
                                    <div class="invalid-feedback">
                                        <?= e($_SESSION['errors']['student_id']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" 
                                       class="form-control <?= isset($_SESSION['errors']['phone']) ? 'is-invalid' : '' ?>" 
                                       id="phone" 
                                       name="phone" 
                                       value="<?= old('phone') ?>">
                                <?php if (isset($_SESSION['errors']['phone'])): ?>
                                    <div class="invalid-feedback">
                                        <?= e($_SESSION['errors']['phone']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control <?= isset($_SESSION['errors']['address']) ? 'is-invalid' : '' ?>" 
                                      id="address" 
                                      name="address" 
                                      rows="2"><?= old('address') ?></textarea>
                            <?php if (isset($_SESSION['errors']['address'])): ?>
                                <div class="invalid-feedback">
                                    <?= e($_SESSION['errors']['address']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-person-plus me-2"></i>Register
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <p>Already have an account? <a href="<?= getBaseUrl() ?>/login" class="text-primary text-decoration-none">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle password visibility
function togglePasswordVisibility(inputId, buttonId) {
    document.getElementById(buttonId).addEventListener('click', function() {
        const input = document.getElementById(inputId);
        const icon = this.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });
}

togglePasswordVisibility('password', 'togglePassword');
togglePasswordVisibility('password_confirm', 'togglePasswordConfirm');

// Bootstrap form validation
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

<?php 
// Clear any session errors after displaying them
unset($_SESSION['errors']); 
?>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 