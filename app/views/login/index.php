<?php require_once 'app/views/templates/headerPublic.php' ?>

<main class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Login</h2>

            <?php if (isset($_SESSION['failedAuth']) && $_SESSION['failedAuth'] > 0): ?>
                <div class="alert alert-danger" role="alert">
                    Invalid username or password. Attempts: <?php echo $_SESSION['failedAuth']; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['lockout_message'])): ?>
                <div class="alert alert-warning" role="alert" id="lockout-alert">
                    <span id="lockout-text"><?php echo htmlspecialchars($_SESSION['lockout_message']); ?></span>
                    <div id="countdown-timer" style="margin-top: 10px; font-weight: bold;"></div>
                </div>
                <script>
               
                let lockoutMessage = "<?php echo addslashes($_SESSION['lockout_message']); ?>";
                let matches = lockoutMessage.match(/(\d+) seconds/);
                if (matches) {
                    let timeLeft = parseInt(matches[1]);
                    let timer = document.getElementById('countdown-timer');
                    let alert = document.getElementById('lockout-alert');
                    
                    let countdown = setInterval(function() {
                        if (timeLeft <= 0) {
                            clearInterval(countdown);
                            alert.innerHTML = '<span class="text-success">Lockout expired! You can now try logging in again.</span>';
                            alert.className = 'alert alert-success';
                            // Auto-refresh the page after 2 seconds
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                        } else {
                            timer.innerHTML = 'Time remaining: ' + timeLeft + ' seconds';
                            timeLeft--;
                        }
                    }, 1000);
                }
                </script>
                <?php unset($_SESSION['lockout_message']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['registration_success'])): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo htmlspecialchars($_SESSION['registration_success']); ?>
                </div>
                <?php unset($_SESSION['registration_success']); ?>
            <?php endif; ?>

            <form action="/login/verify" method="post">
                <fieldset>
                    <div class="form-group mb-3">
                        <label for="username">Username</label>
                        <input required type="text" class="form-control" name="username">
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input required type="password" class="form-control" name="password">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="/register" class="btn btn-link">Don't have an account? Register</a>
                </fieldset>
            </form>
        </div>
    </div>
</main>
<?php require_once 'app/views/templates/footer.php' ?>