<?php
require_once '../includes/config.php';
secure_session_start();
send_security_headers();
require_once '../includes/mailer.php';

// Verify login status
if (!isset($_SESSION['thigazh_admin_logged_in']) || $_SESSION['thigazh_admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// --- 2. SESSION TIMEOUT SECURITY ---
$timeout_duration = 7200;
if (isset($_SESSION['LAST_ACTIVITY'])) {
    if ((time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
        session_unset();
        session_destroy();
        header("Location: login.php?msg=timeout");
        exit;
    }
}
$_SESSION['LAST_ACTIVITY'] = time();

// --- 3. VERIFY LOGIN STATUS REMOVED (Redundant) ---

try {
    $pdo = getDBConnection();
    
    if (!isset($_GET['id'])) {
        header("Location: index.php");
        exit;
    }
    
    $id = (int)$_GET['id'];
    
    // Handle Update
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        
        // Fetch old status BEFORE updating to compare
        $stmt_old = $pdo->prepare("SELECT payment_status FROM registrations WHERE id = :id");
        $stmt_old->execute(['id' => $id]);
        $old_data = $stmt_old->fetch(PDO::FETCH_ASSOC);

        $sql = "UPDATE registrations SET 
                team_name = :team_name, leader_name = :leader_name, 
                member2 = :member2, member2_phone = :member2_phone, 
                member3 = :member3, member4 = :member4, 
                college = :college, department = :department, 
                phone = :phone, email = :email, 
                pass_type = :pass_type, amount = :amount, 
                payment_status = :payment_status 
                WHERE id = :id";
                
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'team_name' => $team_name, 'leader_name' => $leader_name,
            'member2' => $member2, 'member2_phone' => $member2_phone,
            'member3' => $member3, 'member4' => $member4,
            'college' => $college, 'department' => $department,
            'phone' => $phone, 'email' => $email,
            'pass_type' => $pass_type, 'amount' => $amount,
            'payment_status' => $payment_status,
            'id' => $id
        ]);
        
        // Send Verification Email ONLY IF status just changed to 'Completed'
        if ($old_data['payment_status'] !== 'Completed' && $payment_status === 'Completed') {
            $admin_email = ADMIN_EMAIL;
            
            // Fetch the updated record to get json events
            $stmt_new = $pdo->prepare("SELECT selected_events FROM registrations WHERE id = :id");
            $stmt_new->execute(['id' => $id]);
            $new_data = $stmt_new->fetch(PDO::FETCH_ASSOC);
            
            $events = json_decode($new_data['selected_events'], true);
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
            $subject_user = "Registration Verified! - THIGAZH 2K26";
            $body_user = "<p>Congratulations <b>$leader_name</b>!</p>
                         <p>Your payment for <b>Team: $team_name</b> has been successfully verified by our team.</p>
                         <div class='event-list'>
                            <p><strong>Your Confirmed Events:</strong></p>
                            $event_list
                         </div>
                         <p><b>Pass Type:</b> <span class='highlight'>" . strtoupper($pass_type) . " Pass</span></p>
                         <p>Please keep this email handy as your digital confirmation. We are excited to see your team at the event!</p>";
            
            // Admin Email Content
            $subject_admin = "REGISTRATION APPROVED: $team_name";
            $body_admin = "<p>The registration for <b>$team_name</b> has been manually approved.</p>
                          <div class='event-list'>
                            <p><b>Final Details:</b></p>
                            <ul>
                                <li><b>Team Name:</b> $team_name</li>
                                <li><b>Leader:</b> $leader_name ($email)</li>
                                <li><b>Events Confirmed:</b> $event_list</li>
                                <li><b>Status:</b> <span class='highlight'>Completed (Verified)</span></li>
                            </ul>
                          </div>";

            // Send to Participant
            $sent_user = sendThigazhMail($email, $leader_name, $subject_user, $body_user);
            
            // Send to Admin (for record)
            $sent_admin = sendThigazhMail($admin_email, "Admin - THIGAZH", $subject_admin, $body_admin);
            
            if (!$sent_user || !$sent_admin) {
                echo "<script>alert('Warning: Some notification emails could not be sent. Check logs/mail_log.txt if possible.');</script>";
            }
        }
        
        echo "<script>alert('Record updated successfully!'); window.location.href = 'index.php';</script>";
        exit;
    }

    // Fetch the specific record
    $stmt = $pdo->prepare("SELECT * FROM registrations WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $reg = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$reg) {
        showErrorPage("Record Not Found", "The registration record you are trying to edit does not exist.");
    }
    
} catch(PDOException $e) {
    showErrorPage("Database Error", $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Registration | THIGAZH</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&family=Orbitron:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #0a0a23;
            color: #ddd;
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 2rem;
            display: flex;
            justify-content: center;
        }
        .form-container {
            background: #111;
            border: 2px solid #550000;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.2);
            padding: 2rem;
            max-width: 800px;
            width: 100%;
        }
        h1 {
            color: #ff003c;
            font-family: 'Orbitron', sans-serif;
            text-align: center;
            text-transform: uppercase;
            text-shadow: 0 0 10px #ff003c;
            margin-bottom: 2rem;
        }
        .input-group {
            margin-bottom: 1.5rem;
        }
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #fff;
            font-weight: 600;
        }
        input, select {
            width: 100%;
            padding: 0.8rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid #444;
            color: #fff;
            border-radius: 4px;
            font-family: inherit;
            box-sizing: border-box;
        }
        input:focus, select:focus {
            outline: none;
            border-color: #00e5ff;
            box-shadow: 0 0 5px rgba(0, 229, 255, 0.5);
        }
        .btn {
            display: inline-block;
            padding: 1rem 2rem;
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            text-decoration: none;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            text-align: center;
        }
        .primary-btn {
            background: #00e5ff;
            color: #000;
            width: 100%;
            margin-bottom: 1rem;
        }
        .primary-btn:hover { background: #fff; }
        .back-btn {
            background: #333;
            color: #fff;
            width: 100%;
        }
        .back-btn:hover { background: #555; }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Edit Registration #<?= $reg['id'] ?></h1>
        <form method="POST" action="edit.php?id=<?= $reg['id'] ?>">
            <div class="grid-2">
                <div class="input-group">
                    <label>Team Name</label>
                    <input type="text" name="team_name" value="<?= htmlspecialchars($reg['team_name']) ?>" required>
                </div>
                <div class="input-group">
                    <label>Pass Type</label>
                    <select name="pass_type" required>
                        <option value="royal" <?= $reg['pass_type'] === 'royal' ? 'selected' : '' ?>>Royal</option>
                        <option value="elite" <?= $reg['pass_type'] === 'elite' ? 'selected' : '' ?>>Elite</option>
                    </select>
                </div>
            </div>

            <div class="grid-2">
                <div class="input-group">
                    <label>College</label>
                    <input type="text" name="college" value="<?= htmlspecialchars($reg['college']) ?>" required>
                </div>
                <div class="input-group">
                    <label>Department</label>
                    <input type="text" name="department" value="<?= htmlspecialchars($reg['department']) ?>" required>
                </div>
            </div>

            <h3 style="color: #00e5ff; border-bottom: 1px solid #333; padding-bottom: 0.5rem;">Team Members</h3>
            <div class="grid-2">
                <div class="input-group">
                    <label>Leader Name</label>
                    <input type="text" name="leader_name" value="<?= htmlspecialchars($reg['leader_name']) ?>" required>
                </div>
                <div class="input-group">
                    <label>Member 2 Name</label>
                    <input type="text" name="member2" value="<?= htmlspecialchars($reg['member2']) ?>">
                </div>
            </div>
            <div class="grid-2">
                <div class="input-group">
                    <label>Member 3 Name</label>
                    <input type="text" name="member3" value="<?= htmlspecialchars($reg['member3']) ?>">
                </div>
                <div class="input-group">
                    <label>Member 4 Name</label>
                    <input type="text" name="member4" value="<?= htmlspecialchars($reg['member4']) ?>">
                </div>
            </div>

            <h3 style="color: #00e5ff; border-bottom: 1px solid #333; padding-bottom: 0.5rem;">Contact & Payment</h3>
            <div class="grid-2">
                <div class="input-group">
                    <label>Leader Phone</label>
                    <input type="text" name="phone" value="<?= htmlspecialchars($reg['phone']) ?>" required>
                </div>
                <div class="input-group">
                    <label>Leader Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($reg['email']) ?>" required>
                </div>
            </div>
            <div class="grid-2">
                <div class="input-group">
                    <label>Member 2 Phone</label>
                    <input type="text" name="member2_phone" value="<?= htmlspecialchars($reg['member2_phone']) ?>">
                </div>
                <div class="input-group">
                    <label>Amount (₹)</label>
                    <input type="number" name="amount" value="<?= htmlspecialchars($reg['amount']) ?>" required>
                </div>
            </div>
            <div class="input-group">
                <label>Payment Status</label>
                <select name="payment_status" required>
                    <option value="Pending" <?= $reg['payment_status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="Pending Verification" <?= $reg['payment_status'] === 'Pending Verification' ? 'selected' : '' ?>>Pending Verification</option>
                    <option value="Completed" <?= $reg['payment_status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
                </select>
            </div>

            <button type="submit" class="btn primary-btn">Save Changes</button>
            <a href="index.php" class="btn back-btn">Cancel</a>
        </form>
    </div>
</body>
</html>
