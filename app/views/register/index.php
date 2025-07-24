<?php require_once 'app/views/templates/headerPublic.php' ?>

<main class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Register</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="/register/create" method="post">
                <fieldset>
                    <div class="form-group mb-3">
                        <label for="username">Username</label>
                        <input required type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input required type="password" class="form-control" name="password" minlength="6">
                        <small class="form-text text-muted">Password must be at least 6 characters long.</small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="confirm_password">Confirm Password</label>
                        <input required type="password" class="form-control" name="confirm_password" minlength="6">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Register</button>
                    <a href="/login" class="btn btn-link">Already have an account? Login</a>
                </fieldset>
            </form>
        </div>
    </div>
</main>
<?php require_once 'app/views/templates/footer.php' ?>
