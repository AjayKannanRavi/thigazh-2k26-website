<?php
require_once 'includes/config.php';
require_once 'includes/mailer.php';

try {
    $pdo = getDBConnection();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $team_name    = htmlspecialchars($_POST['team_name']    ?? '');
        $leader_name  = htmlspecialchars($_POST['leader_name']  ?? '');
        $member2      = htmlspecialchars($_POST['member2']      ?? '');
        $member2_phone= htmlspecialchars($_POST['member2_phone']?? '');
        $member3      = htmlspecialchars($_POST['member3']      ?? '');
        $member4      = htmlspecialchars($_POST['member4']      ?? '');
        $college      = htmlspecialchars($_POST['college']      ?? '');
        $department   = htmlspecialchars($_POST['department']   ?? '');
        $phone        = trim($_POST['phone']    ?? '');
        $email        = trim($_POST['email']    ?? '');
        $pass_type    = htmlspecialchars($_POST['pass_type']    ?? '');

        // Validate basic inputs
        if (empty($leader_name) || empty($college) || empty($phone) || empty($email) || empty($pass_type)) {
            showErrorPage("Incomplete Data", "Please fill in all required fields.");
        }

        // CHECK FOR DUPLICATE EMAIL
        $check_stmt = $pdo->prepare("SELECT id, is_verified FROM registrations WHERE email = :email LIMIT 1");
        $check_stmt->execute(['email' => $email]);
        $existing = $check_stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            if ($existing['is_verified']) {
                showErrorPage("Already Registered", "This email (<strong>$email</strong>) is already registered and verified for THIGAZH 2K26. Each participant can only register once.");
            } else {
                showErrorPage("Registration Pending", "A registration is already in progress for this email (<strong>$email</strong>). Please check your inbox for the verification code to complete it, or <a href='verify_otp.php?id={$existing['id']}'>click here to verify now</a>.");
            }
        }

        // Handle events selection — Both Royal and Elite now use selected_events[] via checkboxes
        $selected_events = isset($_POST['selected_events']) ? (array)$_POST['selected_events'] : [];
        
        // Elite pass validation
        if ($pass_type === 'elite' && count($selected_events) !== 2) {
            showErrorPage("Invalid Selection", "Elite pass requires exactly 2 events (one from each day).");
        }
        
        // Royal pass validation
        if ($pass_type === 'royal' && count($selected_events) !== 1) {
            showErrorPage("Invalid Selection", "Royal pass requires exactly 1 event.");
        }

        $events_json = json_encode(array_values($selected_events));
        
        // Calculate team size (leader always counts, add optional members)
        $team_size = 1; // Leader
        if (!empty($member2)) $team_size++;
        if (!empty($member3)) $team_size++;
        if (!empty($member4)) $team_size++;

        // Calculate amount based on pass type × team size (matches frontend pricing)
        $price_per_head = ($pass_type === 'elite') ? 400 : 250;
        $amount = $team_size * $price_per_head;

        // Insert into database
        $sql = "INSERT INTO registrations (team_name, leader_name, member2, member2_phone, member3, member4, college, department, phone, email, pass_type, selected_events, amount) 
                VALUES (:team_name, :leader_name, :member2, :member2_phone, :member3, :member4, :college, :department, :phone, :email, :pass_type, :events_json, :amount)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'team_name' => $team_name,
            'leader_name' => $leader_name,
            'member2' => $member2,
            'member2_phone' => $member2_phone,
            'member3' => $member3,
            'member4' => $member4,
            'college' => $college,
            'department' => $department,
            'phone' => $phone,
            'email' => $email,
            'pass_type' => $pass_type,
            'events_json' => $events_json,
            'amount' => $amount
        ]);
        
        $last_id = $pdo->lastInsertId();
        
        
        // Generate and Store OTP
        $otp = sprintf("%06d", mt_rand(1, 999999));
        $expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        
        $otp_stmt = $pdo->prepare("INSERT INTO otp_verifications (registration_id, otp_code, expires_at) VALUES (:reg_id, :otp, :expires)");
        $otp_stmt->execute(['reg_id' => $last_id, 'otp' => $otp, 'expires' => $expires]);
        
        // Send OTP Email
        $subject = "Verify Your Registration - THIGAZH 2K26";
        $body = "
            <h2>Registration OTP</h2>
            <p>Thank you for registering for THIGAZH 2K26, <strong>$leader_name</strong>!</p>
            <p>Your verification code is:</p>
            <div style='background: #1a1a1a; padding: 20px; text-align: center; border: 1px solid #ff003c; border-radius: 4px;'>
                <span style='font-size: 32px; font-weight: bold; color: #ff003c; letter-spacing: 5px;'>$otp</span>
            </div>
            <p style='color: #888; font-size: 0.9rem;'>This OTP is valid for 10 minutes. Please do not share this code with anyone.</p>
        ";
        
        $sent = sendThigazhMail($email, $leader_name, $subject, $body);
        
        if (!$sent) {
            error_log("Failed to send OTP email to $email");
        }
        
        // Redirect to OTP verification page
        header("Location: verify_otp.php?id=" . $last_id);
        exit;
    } else {
        // Redirect to index.php if accessed directly via GET
        header("Location: index.php#registration");
        exit;
    }
} catch(PDOException $e) {
    error_log("DATABASE ERROR in register.php: " . $e->getMessage());
    showErrorPage("Database Error", $e->getMessage());
} catch(Exception $e) {
    error_log("GENERAL ERROR in register.php: " . $e->getMessage());
    showErrorPage("System Error", $e->getMessage());
}
?>
