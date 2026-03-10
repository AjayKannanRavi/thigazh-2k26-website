<?php
session_start();
require_once 'config.php';

// Check if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: view_data.php");
    exit;
}

$error = '';
if (isset($_GET['msg']) && $_GET['msg'] === 'timeout') {
    $error = "Your session expired due to inactivity. Please log in again.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Hardcoded Admin Credentials
    $admin_user = 'thigazh.positivity';
    $admin_pass = 'BOYS@CSE'; // You can change this to a stronger password

    if ($username === $admin_user && $password === $admin_pass) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['LAST_ACTIVITY'] = time(); // Reset activity time on fresh login
        
        // Redirect to admin panel
        header("Location: view_data.php");
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | THIGAZH 2K26</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&family=Orbitron:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #0a0a23;
            color: #ddd;
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: #111;
            padding: 2.5rem;
            border: 2px solid #550000;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.4);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h2 {
            color: #ff003c;
            font-family: 'Orbitron', sans-serif;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
            text-shadow: 0 0 10px #ff003c;
        }
        .input-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #ccc;
            font-weight: 600;
            font-size: 0.9rem;
        }
        input {
            width: 100%;
            padding: 0.8rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid #444;
            color: #fff;
            border-radius: 4px;
            font-family: inherit;
            box-sizing: border-box;
        }
        input:focus {
            outline: none;
            border-color: #00e5ff;
            box-shadow: 0 0 5px rgba(0, 229, 255, 0.5);
        }
        .btn-login {
            background: #00e5ff;
            color: #000;
            border: none;
            padding: 1rem;
            width: 100%;
            font-weight: 800;
            font-family: 'Orbitron', sans-serif;
            text-transform: uppercase;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 1rem;
        }
        .btn-login:hover {
            background: #fff;
        }
        .error-message {
            color: #ff003c;
            margin-bottom: 1rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Panel Login</h2>
        
        <?php if ($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn-login">Login</button>
        </form>
    </div>
</body>
</html>
