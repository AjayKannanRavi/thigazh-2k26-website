<?php
require_once 'includes/config.php';
secure_session_start();
require_once 'includes/mailer.php';

$pdo = getDBConnection();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$id) {
    header("Location: index.php");
    exit;
}

// Check if already verified
$check = $pdo->prepare("SELECT is_verified, email FROM registrations WHERE id = :id");
$check->execute(['id' => $id]);
$reg = $check->fetch(PDO::FETCH_ASSOC);

if (!$reg) {
    showErrorPage("Registration Not Found", "We couldn't find your registration record.");
}

if ($reg['is_verified']) {
    header("Location: payment.php?id=$id");
    exit;
}

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $entered_otp = trim($_POST['otp'] ?? '');
    
    // Validate OTP
    $stmt = $pdo->prepare("SELECT * FROM otp_verifications WHERE registration_id = :id AND otp_code = :otp AND expires_at > NOW() ORDER BY created_at DESC LIMIT 1");
    $stmt->execute(['id' => $id, 'otp' => $entered_otp]);
    $otp_record = $stmt->fetch();
    
    if ($otp_record) {
        // Success! Mark as verified
        $update = $pdo->prepare("UPDATE registrations SET is_verified = 1 WHERE id = :id");
        $update->execute(['id' => $id]);
        
        // Delete OTP records for this ID
        $pdo->prepare("DELETE FROM otp_verifications WHERE registration_id = :id")->execute(['id' => $id]);
        
        header("Location: payment.php?id=$id");
        exit;
    } else {
        $error = "Invalid or expired OTP. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email | THIGAZH 2K26</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/script.js"></script>
    <style>
        body {
            background-color: #050505;
            color: #ddd;
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: rgba(10, 10, 10, 0.95);
            padding: 3rem;
            border: 2px solid #ff003c;
            box-shadow: 0 0 20px rgba(255, 0, 60, 0.3);
            width: 100%;
            max-width: 450px;
            text-align: center;
            border-radius: 8px;
        }
        h2 {
            color: #ff003c;
            font-family: 'Orbitron', sans-serif;
            text-transform: uppercase;
            margin-bottom: 2rem;
            letter-spacing: 2px;
            text-shadow: 0 0 10px rgba(255, 0, 60, 0.5);
        }
        p {
            margin-bottom: 2rem;
            color: #bbb;
            line-height: 1.6;
        }
        .otp-input {
            width: 100%;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid #333;
            color: #fff;
            font-size: 2rem;
            text-align: center;
            letter-spacing: 1rem;
            border-radius: 4px;
            font-family: 'Orbitron', sans-serif;
            margin-bottom: 1.5rem;
            box-sizing: border-box;
        }
        .otp-input:focus {
            outline: none;
            border-color: #00e5ff;
            box-shadow: 0 0 10px rgba(0, 229, 255, 0.3);
        }
        .btn-verify {
            background: #ff003c;
            color: #fff;
            border: none;
            padding: 1rem 2rem;
            width: 100%;
            font-weight: bold;
            font-family: 'Orbitron', sans-serif;
            text-transform: uppercase;
            cursor: pointer;
            border-radius: 4px;
            transition: 0.3s;
            letter-spacing: 2px;
        }
        .btn-verify:hover {
            background: #fff;
            color: #ff003c;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.4);
        }
        .error {
            color: #ff003c;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .footer-links {
            margin-top: 2rem;
            font-size: 0.9rem;
        }
        .footer-links a {
            color: #00e5ff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Verify Email</h2>
        <p>A 6-digit verification code has been sent to<br><strong><?php echo htmlspecialchars($reg['email']); ?></strong></p>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="otp" class="otp-input" maxlength="6" pattern="\d{6}" required placeholder="000000" autocomplete="one-time-code">
            <button type="submit" class="btn-verify">Verify OTP</button>
        </form>

        <div class="footer-links">
            <p>Didn't receive code? <a href="javascript:location.reload()">Resend OTP</a></p>
            <a href="index.php#registration">Change Email</a>
        </div>
    </div>
</body>
</html>
