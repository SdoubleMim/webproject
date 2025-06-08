<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/courses" class="text-light">Courses</a></li>
            <li class="breadcrumb-item active text-light" aria-current="page">Create New Course</li>
        </ol>
    </nav>

    <div class="card" style="background: rgba(157, 78, 221, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(157, 78, 221, 0.2);">
        <div class="card-body">
            <h2 class="card-title text-light mb-4">Create New Course</h2>

            <?php if (isset($errors) && !empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="/courses" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="name" class="form-label text-light">Course Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= old('name') ?>" required
                           style="background: rgba(157, 78, 221, 0.05); border: 1px solid rgba(157, 78, 221, 0.2); color: white;">
                </div>

                <div class="mb-3">
                    <label for="code" class="form-label text-light">Course Code</label>
                    <input type="text" class="form-control" id="code" name="code" value="<?= old('code') ?>" required
                           style="background: rgba(157, 78, 221, 0.05); border: 1px solid rgba(157, 78, 221, 0.2); color: white;">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label text-light">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required
                              style="background: rgba(157, 78, 221, 0.05); border: 1px solid rgba(157, 78, 221, 0.2); color: white;"><?= old('description') ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="credits" class="form-label text-light">Credits</label>
                            <input type="number" class="form-control" id="credits" name="credits" value="<?= old('credits') ?>" required
                                   style="background: rgba(157, 78, 221, 0.05); border: 1px solid rgba(157, 78, 221, 0.2); color: white;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="instructor" class="form-label text-light">Instructor</label>
                            <input type="text" class="form-control" id="instructor" name="instructor" value="<?= old('instructor') ?>" required
                                   style="background: rgba(157, 78, 221, 0.05); border: 1px solid rgba(157, 78, 221, 0.2); color: white;">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="schedule" class="form-label text-light">Schedule</label>
                    <input type="text" class="form-control" id="schedule" name="schedule" value="<?= old('schedule') ?>" required
                           style="background: rgba(157, 78, 221, 0.05); border: 1px solid rgba(157, 78, 221, 0.2); color: white;">
                </div>

                <div class="d-flex justify-content-between">
                    <a href="/courses" class="btn btn-outline-light">Cancel</a>
                    <button type="submit" class="btn btn-primary" style="background-color: #9d4edd; border: none;">Create Course</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 