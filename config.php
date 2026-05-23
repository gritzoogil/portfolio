<?php
define('DB_HOST', 'dpg-d88jt6v7f7vs73baettg-a');
define('DB_NAME', 'portfolio_hub_db_8rp7');
define('DB_USER', 'portfolio_hub_db_8rp7_user');
define('DB_PASS', 'wYVmwxpqI8gt3bFBDJ9flrMeW5rXcJlS');
define('DB_PORT', '5432');

session_start();

function getDBConnection() {
    $conn_string = sprintf(
        "host=%s port=%s dbname=%s user=%s password=%s sslmode=require",
        DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS
    );
    $dbconn = pg_connect($conn_string);
    if (!$dbconn) {
        die("Database connection failed: " . pg_last_error());
    }
    return $dbconn;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}
?>
