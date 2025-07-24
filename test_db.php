
<?php
require_once 'app/core/config.php';

echo "Testing database connection...\n";
echo "Host: " . DB_HOST . "\n";
echo "Port: " . DB_PORT . "\n";
echo "Database: " . DB_DATABASE . "\n";
echo "User: " . DB_USER . "\n";
echo "Password: " . (DB_PASS ? "Set" : "Not Set") . "\n\n";

try {
    $dbh = new PDO('mysql:host=' . DB_HOST . ';port='. DB_PORT . ';dbname=' . DB_DATABASE, DB_USER, DB_PASS);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Database connection successful!\n";
    
    // Test a simple query
    $stmt = $dbh->query("SELECT 1");
    echo "✅ Query test successful!\n";
    
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    
    // Additional debugging
    if (strpos($e->getMessage(), 'getaddrinfo') !== false) {
        echo "❌ DNS resolution failed - hostname may be incorrect\n";
    }
    if (strpos($e->getMessage(), 'Connection refused') !== false) {
        echo "❌ Connection refused - check port and firewall settings\n";
    }
    if (strpos($e->getMessage(), 'Access denied') !== false) {
        echo "❌ Authentication failed - check username/password\n";
    }
}
?>
