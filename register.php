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
             // For Elite pass, capture both daily selections
             if (!empty($_POST['selected_events_day1'])) $selected_events[] = $_POST['selected_events_day1'];
             if (!empty($_POST['selected_events_day2'])) $selected_events[] = $_POST['selected_events_day2'];
        } else {
             // For Royal pass or others, selected_events[] is an array
             $selected_events = isset($_POST['selected_events']) ? (array)$_POST['selected_events'] : [];
        }
        
        $events_json = json_encode($selected_events);

        if(empty($team_name) || empty($leader_name) || empty($college) || empty($phone) || empty($email) || empty($pass_type)) {
             showErrorPage("Missing Fields", "Please fill out all required fields to proceed with your registration.");
        }

        // Check for duplicate email
        $checkEmail = $pdo->prepare("SELECT id FROM registrations WHERE email = :email");
        $checkEmail->execute(['email' => $email]);
        if ($checkEmail->fetch()) {
            showErrorPage("Email Registered", "This email is already registered! If you haven't received your pass, please contact admin.");
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
        
        error_log("Attempting to insert registration for: $email");
        $stmt->execute();
        $last_id = $pdo->lastInsertId();
        error_log("Insert successful. ID: $last_id");
        
        // Generate OTP
        $otp = sprintf("%06d", random_int(0, 999999));
        $expires_at = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        
        // Save OTP
        $otp_stmt = $pdo->prepare("INSERT INTO otp_verifications (registration_id, otp_code, expires_at) VALUES (:reg_id, :otp, :expires)");
        $otp_stmt->execute([
            'reg_id' => $last_id,
            'otp' => $otp,
            'expires' => $expires_at
        ]);
        
        // Send OTP Email
        $subject = "OTP Verification - THIGAZH 2K26";
        $body = "
            <p>Welcome to <b>THIGAZH 2K26</b>!</p>
            <p>To continue with your registration for <b>Team: $team_name</b>, please verify your email using the following One-Time Password (OTP):</p>
            <div style='text-align: center; margin: 30px 0;'>
                <span style='font-size: 32px; font-family: \"Orbitron\", sans-serif; color: #ff003c; letter-spacing: 10px; border: 2px solid #ff003c; padding: 10px 20px; box-shadow: 0 0 15px rgba(255, 0, 60, 0.4);'>$otp</span>
            </div>
            <p style='color: #888; font-size: 0.9rem;'>This OTP is valid for 10 minutes. Please do not share this code with anyone.</p>
        ";
        
        $sent = sendThigazhMail($email, $leader_name, $subject, $body);
        
        if (!$sent) {
            error_log("Failed to send OTP email to $email");
            // We still redirect, but user might be stuck if mail doesn't arrive.
        }
        
        // Redirect to OTP verification page
        header("Location: verify_otp.php?id=" . $last_id);
        exit;
    } else {
        // Redirect to index.html if accessed directly via GET
        header("Location: index.html#registration");
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
