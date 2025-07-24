<?php

/* database connection stuff here
 * 
 */

function db_connect() {
    try { 
        if (DB_TYPE === 'pgsql') {
            // PostgreSQL connection
            $dsn = 'pgsql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_DATABASE;
        } else {
            // MySQL connection with timeout settings
            $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_DATABASE . ';charset=utf8';
        }
        
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 10
        );
        
        $dbh = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $dbh;
    } catch (PDOException $e) {
        error_log("Database connection failed (" . DB_TYPE . "): " . $e->getMessage());
        return null;
    }
}