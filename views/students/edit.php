<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">Edit Profile</h1>
        <div>
            <a href="<?= getBaseUrl() ?>/students/show/<?= $student['id'] ?>" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Back to Profile
            </a>
        </div>
    </div>

    <?php if ($flash = getFlash()): ?>
        <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show" role="alert">
            <?= e($flash['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form action="<?= getBaseUrl() ?>/students/edit/<?= $student['id'] ?>" method="POST" class="needs-validation" novalidate>
                <?= csrf_field() ?>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" 
                               class="form-control <?= isset($_SESSION['errors']['first_name']) ? 'is-invalid' : '' ?>" 
                               id="first_name" 
                               name="first_name" 
                               value="<?= old('first_name', $student['first_name']) ?>" 
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
                               value="<?= old('last_name', $student['last_name']) ?>" 
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
                        <label for="email" class="form-label">Email</label>
                        <input type="email" 
                               class="form-control <?= isset($_SESSION['errors']['email']) ? 'is-invalid' : '' ?>" 
                               id="email" 
                               name="email" 
                               value="<?= old('email', $student['email']) ?>" 
                               required>
                        <?php if (isset($_SESSION['errors']['email'])): ?>
                            <div class="invalid-feedback">
                                <?= e($_SESSION['errors']['email']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" 
                               class="form-control <?= isset($_SESSION['errors']['phone']) ? 'is-invalid' : '' ?>" 
                               id="phone" 
                               name="phone" 
                               value="<?= old('phone', $student['phone']) ?>">
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
                              rows="3"><?= old('address', $student['address']) ?></textarea>
                    <?php if (isset($_SESSION['errors']['address'])): ?>
                        <div class="invalid-feedback">
                            <?= e($_SESSION['errors']['address']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
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