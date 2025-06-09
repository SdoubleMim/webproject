<?php 
// Initialize variables to prevent undefined variable errors
$error = $error ?? 'An unexpected error occurred';
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="display-1 text-primary mb-4">500</h1>
                    <h2 class="mb-4">Internal Server Error</h2>
                    <p class="mb-4">Oops! Something went wrong on our end. Our team has been notified and is working to fix the issue.</p>
                    
                    <div class="alert alert-danger">
                        <?= e($error) ?>
                    </div>
                    
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <a href="<?= getBaseUrl() ?>" class="btn btn-primary mb-3">
                            <i class="bi bi-house-fill"></i> Back to Home
                        </a>
                        <button onclick="history.back()" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left"></i> Go Back
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 