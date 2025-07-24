<?php

class Home extends Controller {

    public function index() {
        // To Check if user is authenticated
        if (!isset($_SESSION['auth']) || $_SESSION['auth'] != 1) {
            header('Location: /login');
            die;
        }
        
        $this->view('home/index');
    }
}
