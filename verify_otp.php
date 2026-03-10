<?php
require_once 'config.php';
require_once 'mailer.php';

try {
    $pdo = getDBConnection();
    
    if (!isset($_GET['id'])) {
        header("Location: register.php");
        exit;
    }
    
    $reg_id = (int)$_GET['id'];
    
    // Fetch registration details
    $stmt = $pdo->prepare("SELECT id, leader_name, email, is_verified FROM registrations WHERE id = :id");
    $stmt->execute(['id' => $reg_id]);
    $reg = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$reg) {
        header("Location: register.php");
        exit;
    }
    
    if ($reg['is_verified']) {
        header("Location: payment.php?id=" . $reg_id);
        exit;
    }
    
    $error = "";
    $success = "";
    
    // Handle OTP Submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['otp'])) {
        $user_otp = trim($_POST['otp']);
        
        // Check OTP in database
        $otpStmt = $pdo->prepare("SELECT * FROM otp_verifications WHERE registration_id = :reg_id AND otp_code = :otp AND expires_at > NOW() ORDER BY created_at DESC LIMIT 1");
        $otpStmt->execute(['reg_id' => $reg_id, 'otp' => $user_otp]);
        $otp_record = $otpStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($otp_record) {
            // Mark as verified
            $updateStmt = $pdo->prepare("UPDATE registrations SET is_verified = 1 WHERE id = :id");
            $updateStmt->execute(['id' => $reg_id]);
            
            // Delete used OTPs for this registration
            $pdo->prepare("DELETE FROM otp_verifications WHERE registration_id = :reg_id")->execute(['reg_id' => $reg_id]);
            
            $success = "Email verified successfully! Redirecting to payment...";
            header("refresh:2;url=payment.php?id=" . $reg_id);
        } else {
            $error = "Invalid or expired OTP. Please try again.";
        }
    }
    
    // Handle Resend OTP
    if (isset($_POST['resend'])) {
        // Delete old OTPs
        $pdo->prepare("DELETE FROM otp_verifications WHERE registration_id = :reg_id")->execute(['reg_id' => $reg_id]);
        
        // Generate new OTP
        $new_otp = random_int(100000, 999999);
        $expires_at = date('Y-m-d H:i:s', strtotime('+5 minutes'));
        
        $pdo->prepare("INSERT INTO otp_verifications (registration_id, otp_code, expires_at) VALUES (:reg_id, :otp, :expires)")
            ->execute(['reg_id' => $reg_id, 'otp' => $new_otp, 'expires' => $expires_at]);
            
        $subject = "Your New Verification Code - THIGAZH 2K26";
        $body = "<p>Hello <b>{$reg['leader_name']}</b>,</p>
                 <p>Your new verification code is:</p>
                 <div class='otp-code'>$new_otp</div>
                 <p class='otp-expiry-notice'>This code will expire in 5 minutes.</p>";
                 
        if (sendThigazhMail($reg['email'], $reg['leader_name'], $subject, $body)) {
            $success = "A new OTP has been sent to your email.";
        } else {
            $error = "Failed to resend OTP. Please check your internet connection.";
        }
    }

} catch(PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email | THIGAZH 2K26</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Orbitron:wght@500;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --midnight: #0a0a23;
            --neon-red: #ff003c;
            --electric-blue: #00e5ff;
        }
        body {
            margin: 0;
            padding: 0;
            background-color: var(--midnight);
            color: #fff;
            font-family: 'Montserrat', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }
        .otp-container {
            background: rgba(13, 13, 43, 0.9);
            border: 2px solid var(--neon-red);
            padding: 3rem;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 0 30px rgba(255, 0, 60, 0.3);
            text-align: center;
            border-radius: 8px;
            position: relative;
        }
        h2 {
            font-family: 'Orbitron', sans-serif;
            text-transform: uppercase;
            color: var(--neon-red);
            margin-bottom: 1rem;
            letter-spacing: 2px;
        }
        p {
            color: #bbb;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }
        .input-group {
            margin-bottom: 2rem;
        }
        input[type="text"] {
            width: 100%;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid #333;
            color: #fff;
            font-family: 'Orbitron', sans-serif;
            font-size: 1.5rem;
            text-align: center;
            letter-spacing: 10px;
            border-radius: 4px;
            transition: 0.3s;
        }
        input[type="text"]:focus {
            outline: none;
            border-color: var(--electric-blue);
            box-shadow: 0 0 10px rgba(0, 229, 255, 0.5);
        }
        .btn-verify {
            width: 100%;
            padding: 1rem;
            background: var(--neon-red);
            color: #fff;
            border: none;
            font-family: 'Orbitron', sans-serif;
            text-transform: uppercase;
            font-weight: 900;
            cursor: pointer;
            transition: 0.3s;
            clip-path: polygon(5% 0, 100% 0, 95% 100%, 0 100%);
        }
        .btn-verify:hover {
            background: #fff;
            color: var(--neon-red);
            box-shadow: 0 0 20px var(--neon-red);
        }
        .btn-resend {
            background: transparent;
            border: none;
            color: var(--electric-blue);
            cursor: pointer;
            font-size: 0.85rem;
            text-decoration: underline;
            margin-top: 1.5rem;
        }
        .error { color: #ff003c; margin-bottom: 1rem; font-weight: bold; }
        .success { color: #00ff88; margin-bottom: 1rem; font-weight: bold; }
        .back-link {
            display: block;
            margin-top: 2rem;
            color: #666;
            text-decoration: none;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="otp-container">
        <h2>Security Check</h2>
        <p>We've sent a 6-digit verification code to <br><b style="color: #fff;"><?php echo htmlspecialchars($reg['email']); ?></b></p>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <input type="text" name="otp" maxlength="6" placeholder="000000" pattern="\d{6}" required autocomplete="off">
            </div>
            <button type="submit" class="btn-verify">Verify OTP</button>
        </form>

        <form method="POST">
            <button type="submit" name="resend" class="btn-resend">Didn't receive code? Resend OTP</button>
        </form>

        <a href="register.php" class="back-link">&larr; Back to Registration</a>
    </div>
</body>
</html>
