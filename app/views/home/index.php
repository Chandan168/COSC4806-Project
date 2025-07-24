
<?php require_once 'app/views/templates/header.php' ?>
<main role="main" class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Dashboard</h1>
                <p class="lead">Welcome to your account, <?= $_SESSION['username'] ?? 'User' ?>!</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Account Information</h5>
                    <p class="card-text">
                        <strong>Username:</strong> <?= $_SESSION['username'] ?? 'Unknown' ?><br>
                        <strong>Login Time:</strong> <?= date('F j, Y, g:i a') ?>
                    </p>
                    <a href="/logout" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once 'app/views/templates/footer.php' ?>
