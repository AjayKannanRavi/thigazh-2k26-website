<?php
$host = 'localhost';
$dbname = 'thigazh_db';
$user = 'root'; 
$pass = 'Ajay@111';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database Error: " . $e->getMessage());
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
        $filename = "pay_" . $pay_id . "_" . time() . "_" . basename($_FILES['payment_screenshot']['name']);
        $target_file = $upload_dir . $filename;
        
        if (move_uploaded_file($_FILES['payment_screenshot']['tmp_name'], $target_file)) {
            $screenshot_path = $target_file;
        } else {
            die("<script>alert('Failed to upload screenshot!'); window.history.back();</script>");
        }
    } else {
        die("<script>alert('Please upload a screenshot!'); window.history.back();</script>");
    }

    $stmt = $pdo->prepare("UPDATE registrations SET payment_status = 'Pending Verification', transaction_id = :txn_id, screenshot_path = :screenshot WHERE id = :id");
    $stmt->execute([
        'txn_id' => $transaction_id,
        'screenshot' => $screenshot_path,
        'id' => $pay_id
    ]);
    
    echo "<script>
        alert('Payment Details Submitted! Your registration is now pending verification.');
        window.location.href = 'index.html';
    </script>";
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    die("<h2 style='color:red; text-align:center; padding: 2rem; font-family: sans-serif;'>Invalid Payment Session!</h2>");
}

$stmt = $pdo->prepare("SELECT * FROM registrations WHERE id = :id");
$stmt->execute(['id' => $id]);
$reg = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reg) {
    die("<h2 style='color:red; text-align:center; padding: 2rem; font-family: sans-serif;'>Registration not found!</h2>");
}

if ($reg['payment_status'] === 'Completed' || $reg['payment_status'] === 'Pending Verification') {
    die("<h2 style='color:#00e5ff; text-align:center; padding: 2rem; font-family: sans-serif; background: #0a0a0a;'>Already Submitted! Verification in progress.</h2>");
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
    <link rel="stylesheet" href="style.css">
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
    <script src="script.js"></script>
</body>
</html>
