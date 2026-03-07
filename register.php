<?php
$host = 'localhost';
$dbname = 'thigazh_db';
$user = 'root'; 
$pass = 'Ajay@111';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
        
        // Redirect to payment portal
        header("Location: payment.php?id=" . $last_id);
        exit;
        
    }
} catch(PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>
