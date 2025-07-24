<?php
if (isset($_SESSION['auth']) && $_SESSION['auth'] == 1) {
    header('Location: /home');
    die;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="/favicon.png">
    <title>COSC 4806 - Reminder App</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }
        .hero-section {
            color: white;
            text-align: center;
            padding: 2rem 0;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="fas fa-sticky-note"></i> COSC 4806 Reminder App
        </a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="/login">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        </div>
    </div>
</nav>

<div class="hero-section">
    <div class="container">
        <h1 class="display-4"><i class="fas fa-clipboard-list"></i> Welcome to Reminder App</h1>
        <p class="lead">Organize your tasks and never forget important reminders</p>
    </div>
</div>

<div class="container mt-4">
