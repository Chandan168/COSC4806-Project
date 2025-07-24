<?php

class Login extends Controller {

    public function index() {
        // Clear old failed attempts that are older than 60 seconds
        if (isset($_SESSION['failedAuth']) && isset($_SESSION['last_failed_time'])) {
            if (time() - $_SESSION['last_failed_time'] > 60) {
                unset($_SESSION['failedAuth']);
                unset($_SESSION['last_failed_time']);
            }
        }
        $this->view('login/index');
    }

    public function verify(){
        $username = $_REQUEST['username'] ?? '';
        $password = $_REQUEST['password'] ?? '';

        $user = $this->model('User');
        $user->authenticate($username, $password); 
    }

}
