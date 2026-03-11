<?php
require_once 'includes/config.php';
require_once 'includes/mailer.php';

try {
    $pdo = getDBConnection();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $team_name = htmlspecialchars($_POST['team_name'] ?? '');
        $leader_name = htmlspecialchars($_POST['leader_name']);
        $member2 = htmlspecialchars($_POST['member2']);
        $member2_phone = isset($_POST['member2_phone']) ? htmlspecialchars($_POST['member2_phone']) : '';
        $member3 = htmlspecialchars($_POST['member3']);
        $member4 = htmlspecialchars($_POST['member4']);
        $college = htmlspecialchars($_POST['college']);
        $department = htmlspecialchars($_POST['department']);
        $phone = trim($_POST['phone'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $pass_type = htmlspecialchars($_POST['pass_type'] ?? ''); 

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
