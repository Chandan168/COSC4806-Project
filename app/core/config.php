<?php

define('VERSION', '0.7.0');
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__DIR__));
define('APPS', ROOT . DS . 'app');
define('CORE', ROOT . DS . 'core');
define('LIBS', ROOT . DS . 'lib');
define('MODELS', ROOT . DS . 'models');
define('VIEWS', ROOT . DS . 'views');
define('CONTROLLERS', ROOT . DS . 'controllers');
define('LOGS', ROOT . DS . 'logs');
define('FILES', ROOT . DS . 'files');

// PostgreSQL (Neon) configuration
define('DB_TYPE', 'pgsql');
define('DB_HOST', getenv('PGHOST'));
define('DB_PORT', getenv('PGPORT'));
define('DB_DATABASE', getenv('PGDATABASE'));
define('DB_USER', getenv('PGUSER'));
define('DB_PASS', getenv('PGPASSWORD'));
