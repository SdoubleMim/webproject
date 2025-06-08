<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="error-page">
                <h1 class="display-1 text-primary mb-4">404</h1>
                <h2 class="mb-4">Page Not Found</h2>
                <p class="lead mb-5">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
                <div class="d-grid gap-2 col-md-6 mx-auto">
                    <a href="<?= getBaseUrl() ?>" class="btn btn-primary">
                        <i class="bi bi-house-door me-2"></i>Back to Home
                    </a>
                    <button onclick="window.history.back()" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-2"></i>Go Back
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-page {
    padding: 40px;
    background: linear-gradient(145deg, #1f1f1f, #2d1b4d);
    border-radius: 15px;
    border: 1px solid rgba(157, 78, 221, 0.2);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.error-page h1 {
    font-size: 120px;
    font-weight: bold;
    text-shadow: 2px 2px 10px rgba(157, 78, 221, 0.5);
}

.error-page h2 {
    color: var(--bs-primary);
}
</style>

<?php require_once __DIR__ . '/partials/footer.php'; ?> 