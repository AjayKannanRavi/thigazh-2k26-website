<?php
require_once 'includes/config.php';
secure_session_start();
require_once 'includes/mailer.php';

try {
    $pdo = getDBConnection();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF logic removed as requested
    }
    
    if (!isset($_GET['id']) && !isset($_POST['pay_id'])) {
        header("Location: index.php");
        exit;
    }
    
    $id = isset($_GET['id']) ? (int)$_GET['id'] : (int)$_POST['pay_id'];
    
    // VERIFICATION CHECK: Ensure user is verified via OTP
    $stmt = $pdo->prepare("SELECT is_verified FROM registrations WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $reg_check = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$reg_check) {
        showErrorPage("Registration Not Found", "We couldn't find your registration record.");
    }
    
    if (!$reg_check['is_verified']) {
        header("Location: verify_otp.php?id=" . $id);
        exit;
    }
    
} catch(PDOException $e) {
    showErrorPage("Database Error", $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pay_id'])) {
    $pay_id = (int)$_POST['pay_id'];
    $transaction_id = htmlspecialchars($_POST['transaction_id']);
    
    $screenshot_path = null;
    if (isset($_FILES['payment_screenshot']) && $_FILES['payment_screenshot']['error'] == 0) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        // Basic image validation
        $allowed_ext = ['jpg', 'jpeg', 'png'];
        $file_ext = strtolower(pathinfo($_FILES['payment_screenshot']['name'], PATHINFO_EXTENSION));
        if (!in_array($file_ext, $allowed_ext)) {
            showErrorPage("Invalid File", "Only JPG, JPEG, and PNG files are allowed.");
        }

        $filename = "pay_" . $pay_id . "_" . time() . "." . $file_ext;
        $target_file = $upload_dir . $filename;
        
        if (move_uploaded_file($_FILES['payment_screenshot']['tmp_name'], $target_file)) {
            $screenshot_path = $target_file;
        } else {
            showErrorPage("Upload Failed", "Failed to upload your payment screenshot. Please try again or check the file size.");
        }
    } else {
        showErrorPage("Screenshot Missing", "Please upload a clear screenshot of your payment confirmation to proceed.");
    }

    $stmt = $pdo->prepare("UPDATE registrations SET payment_status = 'Pending Verification', transaction_id = :txn_id, screenshot_path = :screenshot WHERE id = :id");
    $stmt->execute([
        'txn_id' => $transaction_id,
        'screenshot' => $screenshot_path,
        'id' => $pay_id
    ]);
    
    // 3. Fetch user's full registration details to send email
    $user_stmt = $pdo->prepare("SELECT * FROM registrations WHERE id = :id");
    $user_stmt->execute(['id' => $pay_id]);
    $user = $user_stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $admin_email = ADMIN_EMAIL;
        $events = json_decode($user['selected_events'], true);
        $event_list = "<ul>";
        if (is_array($events)) {
            foreach ($events as $event) {
                if (is_array($event)) {
                    foreach ($event as $e) $event_list .= "<li>" . getEventDisplayName($e) . "</li>";
                } else {
                    $event_list .= "<li>" . getEventDisplayName($event) . "</li>";
                }
            }
        }
        $event_list .= "</ul>";

        // Participant Email Content
        $subject_user = "Registration Received - Waiting for Confirmation";
        $body_user = "<p>Hello <b>{$user['leader_name']}</b>,</p>
                     <p>Your registration for <b>Team: {$user['team_name']}</b> has been successfully submitted!</p>
                     <p>We've received your payment details and screenshot. Our team is now verifying your records.</p>
                     <div class='event-list'>
                        <p><strong>Registered Events:</strong></p>
                        $event_list
                     </div>
                     <p>Total Amount: <span class='highlight'>₹{$user['amount']}</span></p>
                     <p>Status: <span class='highlight'>Waiting for Confirmation</span></p>
                     <p>We will notify you immediately once your verification is completed.</p>";
        
        // Admin Email Content
        $subject_admin = "ACTION REQUIRED: New Registration [{$user['team_name']}]";
        $body_admin = "<p>A new registration has been submitted and is awaiting your verification.</p>
                      <div class='event-list'>
                        <p><b>Team Profile:</b></p>
                        <ul>
                            <li><b>Team Name:</b> {$user['team_name']}</li>
                            <li><b>Leader:</b> {$user['leader_name']} ({$user['email']})</li>
                            <li><b>Phone:</b> {$user['phone']}</li>
                            <li><b>Pass Type:</b> " . strtoupper($user['pass_type']) . "</li>
                            <li><b>Amount:</b> ₹{$user['amount']}</li>
                            <li><b>Txn ID:</b> $transaction_id</li>
                        </ul>
                      </div>
                      <p><b>Selected Events:</b></p>
                      $event_list";

        // Send to Participant
        $sent_user = sendThigazhMail($user['email'], $user['leader_name'], $subject_user, $body_user);
        
        // Send to Admin
        $sent_admin = sendThigazhMail($admin_email, "Admin - THIGAZH", $subject_admin, $body_admin);

        if (!$sent_user || !$sent_admin) {
            echo "<script>alert('Warning: Some notification emails could not be sent. Check mail_log.txt for details.');</script>";
        }
    }
    
    echo "<script>
        alert('Payment Details Submitted! Your registration is now pending verification.');
        window.location.href = 'index.php';
    </script>";
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    showErrorPage("Invalid Session", "The payment link is invalid or has expired. Please try registering again.");
}

$stmt = $pdo->prepare("SELECT * FROM registrations WHERE id = :id");
$stmt->execute(['id' => $id]);
$reg = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reg) {
    showErrorPage("Not Found", "We couldn't find your registration record. Please contact the help desk.");
}

if ($reg['payment_status'] === 'Completed' || $reg['payment_status'] === 'Pending Verification') {
    showErrorPage("Submission Received", "You have already submitted your payment proof! Our team is verifying your registration.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Portal | THIGAZH 2K26</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700;900&family=Montserrat:wght@400;600;800;900&family=Orbitron:wght@500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href=" style.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: var(--bg-dark);
            margin: 0;
        }
        .payment-card {
            max-width: 500px;
            width: 100%;
            text-align: center;
            z-index: 10;
        }
        .payment-details {
            margin-top:2rem;
            text-align: left;
            background: rgba(0,0,0,0.5);
            padding: 1.5rem;
            border: 1px dashed var(--neon-red);
        }
        .payment-details p {
            font-size: 1.1rem;
            color: var(--metallic-silver);
            margin-bottom: 0.8rem;
            font-family: var(--font-ui);
        }
        .payment-details strong {
            color: var(--text-light);
        }
        .payment-amount {
            font-size: 3.5rem;
            color: var(--neon-red);
            font-family: var(--font-heading);
            margin: 2rem 0;
            text-shadow: 0 0 15px rgba(255,0,0,0.8);
        }
        .qr-placeholder {
            width: 150px;
            height: 150px;
            background: #fff;
            margin: 1rem auto;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-family: var(--font-ui);
            font-weight: bold;
            border: 4px solid var(--electric-blue);
        }
        .subtext {
            color: var(--text-muted);
            font-size: 0.9rem;
            font-family: var(--font-ui);
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <div class="halftone-overlay"></div>
    <div class="vignette-overlay"></div>
    <canvas id="particle-canvas" style="position:fixed; top:0; left:0; width:100%; height:100%; z-index:0;"></canvas>
    
    <div class="payment-card comic-panel">
        <h2 class="glitch" data-text="PAYMENT SUMMARY">PAYMENT SUMMARY</h2>
        
        <div class="payment-details">
            <p><strong>Team Name:</strong> <?= htmlspecialchars($reg['team_name']) ?></p>
            <p><strong>Leader:</strong> <?= htmlspecialchars($reg['leader_name']) ?></p>
            <p><strong>Pass Type:</strong> <?= strtoupper(htmlspecialchars($reg['pass_type'])) ?> PASS</p>
            <p><strong>Team Size:</strong> <?= ($reg['amount'] / ($reg['pass_type'] === 'royal' ? 250 : 400)) ?> Members</p>
        </div>
        
        <div class="payment-amount">
            ₹<?= htmlspecialchars($reg['amount']) ?>
        </div>

        <div class="qr-placeholder">
            [ QR CODE ]<br>Scan to Pay
        </div>
        <p class="subtext">Scan using any UPI App (GPay, PhonePe, Paytm)</p>
        
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="pay_id" value="<?= $reg['id'] ?>">
            
            <div class="input-group" style="margin-top: 1rem; text-align: left;">
                <label for="transaction_id">Transaction ID / UTR Number</label>
                <input type="text" id="transaction_id" name="transaction_id" required placeholder="e.g. 123456789012">
            </div>

            <div class="input-group" style="text-align: left; margin-bottom: 2rem;">
                <label for="payment_screenshot">Upload Payment Screenshot (JPG/PNG)</label>
                <input type="file" id="payment_screenshot" name="payment_screenshot" accept="image/*" required style="padding: 0.5rem; background: rgba(255,255,255,0.05); color: white; border: 2px solid var(--text-muted); width: 100%; font-family: var(--font-body);">
            </div>

            <button type="submit" class="btn primary-btn g-btn" style="width:100%">SUBMIT PAYMENT DETAILS</button>
        </form>
    </div>

    <!-- Keep background particles active for aesthetics -->
    <script src=" script.js"></script>
</body>
</html>
