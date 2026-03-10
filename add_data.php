<?php
session_start();
require_once 'config.php';
require_once 'mailer.php';

// Verify login status
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pdo = getDBConnection();
        
        $team_name = htmlspecialchars($_POST['team_name']);
        $leader_name = htmlspecialchars($_POST['leader_name']);
        $member2 = htmlspecialchars($_POST['member2']);
        $member2_phone = htmlspecialchars($_POST['member2_phone']);
        $member3 = htmlspecialchars($_POST['member3']);
        $member4 = htmlspecialchars($_POST['member4']);
        $college = htmlspecialchars($_POST['college']);
        $department = htmlspecialchars($_POST['department']);
        $phone = htmlspecialchars($_POST['phone']);
        $email = htmlspecialchars($_POST['email']);
        $pass_type = htmlspecialchars($_POST['pass_type']);
        $amount = (int)$_POST['amount'];
        $payment_status = htmlspecialchars($_POST['payment_status']);
        
        // Handle events
        $selected_events = isset($_POST['selected_events']) ? $_POST['selected_events'] : [];
        $events_json = json_encode($selected_events);

        $sql = "INSERT INTO registrations (team_name, leader_name, member2, member2_phone, member3, member4, college, department, phone, email, pass_type, selected_events, amount, payment_status) 
                VALUES (:team_name, :leader_name, :member2, :member2_phone, :member3, :member4, :college, :department, :phone, :email, :pass_type, :events_json, :amount, :payment_status)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'team_name' => $team_name, 'leader_name' => $leader_name,
            'member2' => $member2, 'member2_phone' => $member2_phone,
            'member3' => $member3, 'member4' => $member4,
            'college' => $college, 'department' => $department,
            'phone' => $phone, 'email' => $email,
            'pass_type' => $pass_type, 'events_json' => $events_json,
            'amount' => $amount, 'payment_status' => $payment_status
        ]);

        $msg = "<p style='color: #00ff88; text-align:center;'>Record added successfully!</p>";
        header("refresh:2;url=view_data.php");
    } catch (PDOException $e) {
        $msg = "<p style='color: #ff003c; text-align:center;'>Error: " . $e->getMessage() . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Registration | Admin</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { background: #050505; color: white; padding: 20px; }
        .admin-form { max-width: 800px; margin: 0 auto; background: #111; padding: 30px; border: 1px solid #ff003c; border-radius: 8px; }
        .input-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; color: #ff003c; font-weight: bold; }
        input, select { width: 100%; padding: 12px; background: #222; border: 1px solid #444; color: white; border-radius: 4px; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .btn-submit { background: #ff003c; color: white; padding: 15px 30px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%; margin-top: 20px; }
        .back-link { display: block; margin-bottom: 20px; color: #ccc; text-decoration: none; }
        .event-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; background: #1a1a1a; padding: 15px; border-radius: 4px; }
        .event-item { display: flex; align-items: center; gap: 10px; }
        .event-item input { width: auto; }
    </style>
</head>
<body>
    <div class="admin-form">
        <a href="view_data.php" class="back-link">← Back to Dashboard</a>
        <h2 style="color: #ff003c; text-align: center; margin-bottom: 30px;">Add New Registration</h2>
        
        <?= $msg ?>

        <form action="" method="POST">
            <div class="grid-2">
                <div class="input-group">
                    <label>Team Name</label>
                    <input type="text" name="team_name" required>
                </div>
                <div class="input-group">
                    <label>Leader Name</label>
                    <input type="text" name="leader_name" required>
                </div>
            </div>

            <div class="grid-2">
                <div class="input-group">
                    <label>College</label>
                    <input type="text" name="college" required>
                </div>
                <div class="input-group">
                    <label>Department</label>
                    <input type="text" name="department" required>
                </div>
            </div>

            <div class="grid-2">
                <div class="input-group">
                    <label>Phone</label>
                    <input type="tel" name="phone" required>
                </div>
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
            </div>

            <h3 style="color: #ff003c; margin: 20px 0 10px;">Team Members</h3>
            <div class="grid-2">
                <div class="input-group">
                    <label>Member 2</label>
                    <input type="text" name="member2">
                </div>
                <div class="input-group">
                    <label>Member 2 Phone</label>
                    <input type="text" name="member2_phone">
                </div>
            </div>
            <div class="grid-2">
                <div class="input-group">
                    <label>Member 3</label>
                    <input type="text" name="member3">
                </div>
                <div class="input-group">
                    <label>Member 4</label>
                    <input type="text" name="member4">
                </div>
            </div>

            <h3 style="color: #ff003c; margin: 20px 0 10px;">Participation Details</h3>
            <div class="grid-2">
                <div class="input-group">
                    <label>Pass Type</label>
                    <select name="pass_type" required>
                        <option value="royal">Royal Pass (1 Event)</option>
                        <option value="elite">Elite Pass (2 Events)</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>Amount (₹)</label>
                    <input type="number" name="amount" value="0">
                </div>
            </div>

            <div class="input-group">
                <label>Payment Status</label>
                <select name="payment_status">
                    <option value="Pending">Pending</option>
                    <option value="Pending Verification">Pending Verification</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>

            <label>Select Events</label>
            <div class="event-grid">
                <div class="event-item"><input type="checkbox" name="selected_events[]" value="codeathon"> Codeathon (Day 1)</div>
                <div class="event-item"><input type="checkbox" name="selected_events[]" value="project_expo"> Project Expo (Day 1)</div>
                <div class="event-item"><input type="checkbox" name="selected_events[]" value="mindsynth"> MindSynth (Day 1)</div>
                <div class="event-item"><input type="checkbox" name="selected_events[]" value="console_app"> Console App (Day 2)</div>
                <div class="event-item"><input type="checkbox" name="selected_events[]" value="arachnid"> Arachnid Cipher (Day 2)</div>
            </div>

            <button type="submit" class="btn-submit">Add Record</button>
        </form>
    </div>
</body>
</html>
