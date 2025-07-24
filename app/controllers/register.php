<?php

class Register extends Controller {

    public function index() {
        // Clear old failed attempts that are older than 60 seconds
        if (isset($_SESSION['failedAuth']) && isset($_SESSION['last_failed_time'])) {
            if (time() - $_SESSION['last_failed_time'] > 60) {
                unset($_SESSION['failedAuth']);
                unset($_SESSION['last_failed_time']);
            }
        }
        $this->view('register/index');
    }

    public function create() {
        $username = $_REQUEST['username'] ?? '';
        $password = $_REQUEST['password'] ?? '';
        $confirm_password = $_REQUEST['confirm_password'] ?? '';

        // Validate input
        if (empty($username) || empty($password) || empty($confirm_password)) {
            $this->view('register/index', ['error' => 'All fields are required.']);
            return;
        }

        if ($password !== $confirm_password) {
            $this->view('register/index', ['error' => 'Passwords do not match.']);
            return;
        }

        if (strlen($password) < 6) {
            $this->view('register/index', ['error' => 'Password must be at least 6 characters long.']);
            return;
        }

        $user = $this->model('User');

        // Check if username already exists
        if ($user->getUserIdByUsername($username)) {
            $this->view('register/index', ['error' => 'Username already exists.']);
            return;
        }

        // Create the user
        if ($user->createUser($username, $password)) {
            $_SESSION['registration_success'] = 'Account created successfully! You can now log in.';
            header('Location: /login');
            exit;
        } else {
            $this->view('register/index', ['error' => 'Failed to create account. Please try again.']);
        }
    }
}
