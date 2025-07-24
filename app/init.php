<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('session.gc_maxlifetime', 28800);
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
$sessionCookieExpireTime = 28800; // 8hrs
session_set_cookie_params($sessionCookieExpireTime);
session_start();

// Set timezone to Toronto, Canada (Eastern Time)
date_default_timezone_set('America/Toronto');

require_once 'core/App.php';
require_once 'core/Controller.php';
require_once 'core/config.php';
require_once 'database.php';