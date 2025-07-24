</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <footer class="bg-dark text-light mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-sticky-note"></i> COSC 4806 Reminder App</h5>
                    <p class="mb-0">Your personal task management solution</p>
                    <small class="text-muted">Built with PHP & Bootstrap</small>
                </div>
                <div class="col-md-4">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled">
                        <?php if (isset($_SESSION['auth']) && $_SESSION['auth'] == 1): ?>
                            <li><a href="/home" class="text-light text-decoration-none"><i class="fas fa-home"></i> Dashboard</a></li>
                            <li><a href="/reminders" class="text-light text-decoration-none"><i class="fas fa-sticky-note"></i> My Reminders</a></li>
                            <li><a href="/logout" class="text-light text-decoration-none"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        <?php else: ?>
                            <li><a href="/login" class="text-light text-decoration-none"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6>Support</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none"><i class="fas fa-question-circle"></i> Help Center</a></li>
                        <li><a href="#" class="text-light text-decoration-none"><i class="fas fa-envelope"></i> Contact Us</a></li>
                        <li><a href="#" class="text-light text-decoration-none"><i class="fas fa-shield-alt"></i> Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <small>&copy; 2024 COSC 4806 Reminder App. All rights reserved.</small>
                </div>
                <div class="col-md-6 text-end">
                    <small>Version 1.0 | Made with <i class="fas fa-heart text-danger"></i></small>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Auto-hide toasts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'));
            var toastList = toastElList.map(function(toastEl) {
                return new bootstrap.Toast(toastEl, {delay: 5000});
            });
        });
    </script>
</body>
</html>