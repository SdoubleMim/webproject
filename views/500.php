<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="error-page">
                <h1 class="display-1 text-primary mb-4">500</h1>
                <h2 class="mb-4">Internal Server Error</h2>
                <p class="lead mb-5">Oops! Something went wrong on our end. Our team has been notified and is working to fix the issue.</p>
                <?php if (isset($message) && !empty($message)): ?>
                    <div class="alert alert-danger mb-4">
                        <pre class="mb-0"><code><?= e($message) ?></code></pre>
                    </div>
                <?php endif; ?>
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

.error-page pre {
    background: rgba(31, 31, 31, 0.8);
    border-radius: 5px;
    padding: 15px;
    color: #ff6b6b;
    max-height: 200px;
    overflow-y: auto;
}
</style>

<?php require_once __DIR__ . '/partials/footer.php'; ?> 