<?php
require_once 'app/init.php';

$username = 'admin';
$newPassword = 'admin';

$db = db_connect();
if ($db === null) {
    echo "❌ Database connection failed\n";
    exit;
}

// Hash the new password
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

// Update the admin user's password
$statement = $db->prepare("UPDATE users SET password = :password WHERE username = :username");
$statement->bindValue(':username', strtolower($username));
$statement->bindValue(':password', $hashedPassword);

if ($statement->execute()) {
    echo "✅ Password updated successfully for user: $username\n";
} else {
    echo "❌ Failed to update password\n";
}
?>
