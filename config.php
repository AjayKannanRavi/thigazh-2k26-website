<?php
// config.php
// Centralized configuration for THIGAZH 2K26 website

// Database Configuration
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'thigazh_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// File & Path Configuration
define('BASE_PATH', __DIR__);
define('UPLOAD_DIR', BASE_PATH . '/uploads/');
define('SITE_URL', (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']));

// Admin Email (where notifications are sent)
define('ADMIN_EMAIL', 'real.kiransurya@gmail.com');

// SMTP Credentials
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USER', 'real.kiransurya@gmail.com');
define('SMTP_PASS', 'ycndvmnmenksqfcb');
define('SMTP_PORT', 587);

/**
 * Returns a PDO connection using the centralized config.
 */
function getDBConnection() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Database Connection Error: " . $e->getMessage());
    }
}
?>
