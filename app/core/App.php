<?php

class App {

    protected $controller = 'login';
    protected $method = 'index';
    protected $special_url = ['register'];
    protected $params = [];

    public function __construct() {
        // Parse URL first
        $url = $this->parseUrl();
        
        error_log("URL parts: " . print_r($url, true));

 
        if (isset($url[0]) && !empty($url[0]) && file_exists('app/controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            $_SESSION['controller'] = $this->controller;
            
            if (isset($url[1]) && !empty($url[1])) {
                $this->method = $url[1];
            }
            
        } else {
    
            if (isset($_SESSION['auth']) && $_SESSION['auth'] == 1) {
                $this->controller = 'home';
            }
        }

        // Debug: log controller and method
        error_log("Controller: " . $this->controller . ", Method: " . $this->method);

        // Load controller
        require_once 'app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Verify method exists
        if (!method_exists($this->controller, $this->method)) {
            $this->method = 'index';
        }

        // Set parameters (skip controller and method parts)
        $this->params = array_slice($url, 2);

        // Call controller method with parameters
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        // First try the rewrite URL parameter
        if (isset($_GET['url']) && !empty($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        
        if (isset($_SERVER['REQUEST_URI'])) {
            $uri = $_SERVER['REQUEST_URI'];
            // Remove query string
            $uri = strtok($uri, '?');
            // Remove leading slash and trailing slash
            $uri = trim($uri, '/');
            
            if (!empty($uri)) {
                $uri = filter_var($uri, FILTER_SANITIZE_URL);
                return explode('/', $uri);
            }
        }
        
        return [];
    }
}