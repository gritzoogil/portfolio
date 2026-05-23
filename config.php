<?php
// Database Configuration

define('DB_HOST', 'ep-rapid-wave-aolqvcbo.c-2.ap-southeast-1.aws.neon.tech');
define('DB_NAME', 'neondb');
define('DB_USER', 'neondb_owner');
define('DB_PASS', 'npg_RegkzKl68bQc');
define('DB_PORT', '5432');

session_start();

function getDBConnection() {
    $conn_string = sprintf(
        "host=%s port=%s dbname=%s user=%s password=%s",
        DB_HOST,
        DB_PORT,
        DB_NAME,
        DB_USER,
        DB_PASS
    );
    
    $dbconn = pg_connect($conn_string);
    
    if (!$dbconn) {
        die("Database connection failed: " . pg_last_error());
    }
    
    return $dbconn;
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Redirect if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

// Sanitize input
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}
?>
