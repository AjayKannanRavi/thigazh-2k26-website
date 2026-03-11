<?php
// Centralized configuration for THIGAZH 2K26 website
date_default_timezone_set('Asia/Kolkata');

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'thigazh_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Admin Credentials (Encapsulated)
define('ADMIN_USER', 'thigazh.positivity');
define('ADMIN_PASS', 'BOYS@CSE');

// File & Path Configuration
define('BASE_PATH', dirname(__DIR__));
define('UPLOAD_DIR', BASE_PATH . '/uploads/');
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
$self = isset($_SERVER['PHP_SELF']) ? dirname($_SERVER['PHP_SELF']) : '';
define('SITE_URL', (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $host . $self);

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
        
        // Sync MySQL timezone with PHP timezone
        $now = new DateTime();
        $mins = $now->getOffset() / 60;
        $sgn = ($mins < 0 ? -1 : 1);
        $mins = abs($mins);
        $hrs = floor($mins / 60);
        $mins -= $hrs * 60;
        $offset = sprintf('%+d:%02d', $hrs * $sgn, $mins);
        $pdo->exec("SET time_zone='$offset';");
        
        return $pdo;
    } catch (PDOException $e) {
        showErrorPage("Database Connection Error", $e->getMessage());
    }
}

/**
 * Renders a premium Red Neon themed error page.
 */
function showErrorPage($title, $message) {
    die("
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>$title | THIGAZH 2K26</title>
        <link href='https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Montserrat:wght@300;400;700&display=swap' rel='stylesheet'>
        <style>
            body { 
                background: #050505; 
                color: #ffffff; 
                font-family: 'Montserrat', sans-serif; 
                margin: 0; 
                height: 100vh; 
                display: flex; 
                align-items: center; 
                justify-content: center; 
                overflow: hidden;
            }
            .error-card {
                background: rgba(17, 17, 17, 0.9);
                border: 2px solid #ff003c;
                padding: 40px;
                border-radius: 12px;
                text-align: center;
                max-width: 500px;
                width: 90%;
                box-shadow: 0 0 30px rgba(255, 0, 60, 0.3);
                position: relative;
            }
            .error-card::before {
                content: '';
                position: absolute;
                top: -2px; left: -2px; right: -2px; bottom: -2px;
                background: linear-gradient(45deg, #ff003c, #00e5ff, #ff003c);
                z-index: -1;
                filter: blur(10px);
                opacity: 0.5;
                border-radius: 12px;
            }
            h1 {
                font-family: 'Orbitron', sans-serif;
                color: #ff003c;
                text-transform: uppercase;
                letter-spacing: 4px;
                margin-bottom: 20px;
                text-shadow: 0 0 10px rgba(255, 0, 60, 0.8);
            }
            p {
                color: #cccccc;
                font-size: 1.1rem;
                line-height: 1.6;
                margin-bottom: 30px;
            }
            .btn {
                background: #ff003c;
                color: white;
                text-decoration: none;
                padding: 12px 30px;
                border-radius: 4px;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 2px;
                transition: 0.3s;
                display: inline-block;
                cursor: pointer;
            }
            .btn:hover {
                background: #ffffff;
                color: #ff003c;
                box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
            }
        </style>
    </head>
    <body>
        <div class='error-card'>
            <h1>$title</h1>
            <p>$message</p>
            <a href='javascript:history.back()' class='btn'>Back to Registration</a>
        </div>
    </body>
    </html>
    ");
}

/**
 * Starts a session.
 */
function secure_session_start() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Sends security headers (Disabled).
 */
function send_security_headers() {
    // Disabled
}

?>
