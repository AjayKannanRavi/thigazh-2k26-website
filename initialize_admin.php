<?php
require_once 'config.php';

// Check if admins already exist to prevent accidental overwrites
$pdo = getDBConnection();
$stmt = $pdo->query("SELECT COUNT(*) FROM admins");
$adminCount = $stmt->fetchColumn();

if ($adminCount > 0) {
    die("Admin already initialized. Delete this file for security.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username']);
    $pass = $_POST['password'];
    $email = trim($_POST['email']);
    
    if (empty($user) || empty($pass) || empty($email)) {
        $error = "All fields are required.";
    } else {
        $hash = password_hash($pass, PASSWORD_BCRYPT);
        
        $stmt = $pdo->prepare("INSERT INTO admins (username, password_hash, email) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$user, $hash, $email]);
            $success = "Admin created successfully! DELETE THIS FILE IMMEDIATELY.";
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Initialize Admin</title>
    <style>
        body { background: #050505; color: #fff; font-family: sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .box { background: #111; padding: 2rem; border: 2px solid #ff003c; border-radius: 8px; box-shadow: 0 0 20px rgba(255,0,60,0.3); }
        input { display: block; width: 100%; margin: 10px 0; padding: 10px; background: #222; border: 1px solid #444; color: #fff; }
        button { background: #ff003c; color: #fff; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px; font-weight: bold; width: 100%; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Setup Admin Account</h2>
        <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
        <?php if(isset($success)) echo "<p style='color:green'>$success</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Create Admin</button>
        </form>
    </div>
</body>
</html>
