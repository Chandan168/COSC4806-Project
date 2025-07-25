<?php if (isset($_SESSION['auth'])): ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" href="/favicon.png">
    <title>Movies Hotstar</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <style>
        .navbar-brand {
            font-weight: bold;
            color: #007bff !important;
        }
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
        }
        .admin-badge {
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.8em;
            margin-left: 5px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/home">
            <i class="fas fa-film"></i> Movies Hotstar
        </a>
        <div class="navbar-nav me-auto">
            <a class="nav-link" href="/home">
                <i class="fas fa-home"></i> Home
            </a>
            <a class="nav-link" href="/movies">
                <i class="fas fa-film"></i> Movies
            </a>
        </div>
        <div class="navbar-nav ms-auto">
            <span class="navbar-text">
                Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?>
                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
                    <span class="admin-badge">ADMIN</span>
                <?php endif; ?>
            </span>
        </div>
    </div>
</nav>

<!-- Toast Container for Notifications -->
<div class="toast-container">
    <?php if (isset($_SESSION['success_message'])): ?>
    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
        <div class="toast-header bg-success text-white">
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <?php echo htmlspecialchars($_SESSION['success_message']); ?>
        </div>
    </div>
    <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
        <div class="toast-header bg-danger text-white">
            <strong class="me-auto">Error</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <?php echo htmlspecialchars($_SESSION['error_message']); ?>
        </div>
    </div>
    <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
</div>

<?php endif; ?>
</body>
</html>
