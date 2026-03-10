<?php
require_once 'config.php';
require_once 'mailer.php';

try {
    $pdo = getDBConnection();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $team_name = htmlspecialchars($_POST['team_name']);
        $leader_name = htmlspecialchars($_POST['leader_name']);
        $member2 = htmlspecialchars($_POST['member2']);
        $member2_phone = isset($_POST['member2_phone']) ? htmlspecialchars($_POST['member2_phone']) : '';
        $member3 = htmlspecialchars($_POST['member3']);
        $member4 = htmlspecialchars($_POST['member4']);
        $college = htmlspecialchars($_POST['college']);
        $department = htmlspecialchars($_POST['department']);
        $phone = htmlspecialchars($_POST['phone']);
        $email = htmlspecialchars($_POST['email']);
        $pass_type = htmlspecialchars($_POST['pass_type']); 
        
        $selected_events = [];
        if ($pass_type === 'elite') {
             // For Elite pass, gather both daily selections into the main array
             if (isset($_POST['selected_events_day1'])) $selected_events[] = $_POST['selected_events_day1'];
             if (isset($_POST['selected_events_day2'])) $selected_events[] = $_POST['selected_events_day2'];
        } else {
             $selected_events = isset($_POST['selected_events']) ? $_POST['selected_events'] : [];
        }
        
        $events_json = json_encode($selected_events);

        if(empty($team_name) || empty($leader_name) || empty($college) || empty($phone) || empty($email) || empty($pass_type)) {
             die("<script>alert('Please fill out all required fields!'); window.history.back();</script>");
        }

        // Check for duplicate email
        $checkEmail = $pdo->prepare("SELECT id FROM registrations WHERE email = :email");
        $checkEmail->execute(['email' => $email]);
        if ($checkEmail->fetch()) {
            die("<script>alert('This email is already registered! If you haven't received your pass, please contact admin.'); window.history.back();</script>");
        }
        
        // Calculate Amount Based on Team Size & Pass Type
        $team_size = 1; // Leader
        if (!empty($member2)) $team_size++;
        if (!empty($member3)) $team_size++;
        if (!empty($member4)) $team_size++;
        
        $amount = 0;
        if ($pass_type === 'royal') {
            $amount = $team_size * 250;
        } else if ($pass_type === 'elite') {
            $amount = $team_size * 400;
        }

        $sql = "INSERT INTO registrations (team_name, leader_name, member2, member2_phone, member3, member4, college, department, phone, email, pass_type, selected_events, amount, payment_status) 
                VALUES (:team_name, :leader_name, :member2, :member2_phone, :member3, :member4, :college, :department, :phone, :email, :pass_type, :events_json, :amount, 'Pending')";
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':team_name', $team_name);
        $stmt->bindParam(':leader_name', $leader_name);
        $stmt->bindParam(':member2', $member2);
        $stmt->bindParam(':member2_phone', $member2_phone);
        $stmt->bindParam(':member3', $member3);
        $stmt->bindParam(':member4', $member4);
        $stmt->bindParam(':college', $college);
        $stmt->bindParam(':department', $department);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass_type', $pass_type);
        $stmt->bindParam(':events_json', $events_json);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
        
        $stmt->execute();
        
        $last_id = $pdo->lastInsertId();
        
        // --- OTP GENERATION ---
        // Generating a cryptographically secure 6-digit random number
        $otp = random_int(100000, 999999);
        $expires_at = date('Y-m-d H:i:s', strtotime('+5 minutes'));
        
        $otpStmt = $pdo->prepare("INSERT INTO otp_verifications (registration_id, otp_code, expires_at) VALUES (:reg_id, :otp, :expires)");
        $otpStmt->execute([
            'reg_id' => $last_id,
            'otp' => $otp,
            'expires' => $expires_at
        ]);
        
        // --- SEND OTP EMAIL ---
        $subject = "Verify Your Email - THIGAZH 2K26";
        $body = "<p>Hello <b>$leader_name</b>,</p>
                 <p>Thank you for starting your registration for THIGAZH 2K26. To ensure your security and complete your registration, please enter the following verification code:</p>
                 <div class='otp-code'>$otp</div>
                 <p class='otp-expiry-notice'>This code will expire in 5 minutes.</p>
                 <p>If you did not request this code, please ignore this email.</p>";
        
        if (sendThigazhMail($email, $leader_name, $subject, $body)) {
            // Redirect to verify OTP page
            header("Location: verify_otp.php?id=" . $last_id);
            exit;
        } else {
             die("<script>alert('Failed to send verification email. Please try again or check your email address.'); window.history.back();</script>");
        }
    }
} catch(PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>
