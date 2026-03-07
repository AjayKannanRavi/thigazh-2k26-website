<?php
$host = 'localhost';
$dbname = 'thigazh_db';
$user = 'root'; 
$pass = 'Ajay@111';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Handle Verification Approval
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_id'])) {
        $verify_id = (int)$_POST['verify_id'];
        $updateStmt = $pdo->prepare("UPDATE registrations SET payment_status = 'Completed' WHERE id = :id");
        $updateStmt->execute(['id' => $verify_id]);
        
        // Refresh the page to show the update
        header("Location: view_data.php");
        exit;
    }

    // Fetch all records ordered by newest first
    $stmt = $pdo->query("SELECT * FROM registrations ORDER BY created_at DESC");
    $registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | THIGAZH Registrations</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&family=Orbitron:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #050510;
            color: #ddd;
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 2rem;
        }
        h1 {
            color: #ff003c;
            font-family: 'Orbitron', sans-serif;
            text-align: center;
            text-transform: uppercase;
            text-shadow: 0 0 10px #ff003c;
            margin-bottom: 2rem;
        }
        .table-container {
            width: 100%;
            overflow-x: auto;
            border: 2px solid #550000;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.2);
            background: #111;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        th, td {
            padding: 1rem;
            border-bottom: 1px solid #333;
            border-right: 1px dashed #333;
        }
        th {
            background: #220000;
            color: #ff003c;
            font-family: 'Orbitron', sans-serif;
            font-size: 0.9rem;
            text-transform: uppercase;
        }
        tr:hover {
            background: rgba(255, 0, 60, 0.1);
        }
        .status-completed { color: #00ff88; font-weight: bold; }
        .status-pending { color: #ffd700; font-weight: bold; }
        .status-verifying { color: #00e5ff; font-weight: bold; }
        
        .screenshot-btn, .verify-btn {
            display: inline-block;
            padding: 5px 10px;
            color: #000;
            text-decoration: none;
            font-weight: bold;
            font-size: 0.8rem;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            margin-top: 5px;
        }
        .screenshot-btn { background: #00e5ff; }
        .verify-btn { background: #00ff88; }
        .screenshot-btn:hover, .verify-btn:hover { background: #fff; }
        
        .empty-message { text-align: center; padding: 2rem; color: #888; }
    </style>
</head>
<body>
    <h1>Data Base Registrations</h1>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Team Name</th>
                    <th>Leader (Contact)</th>
                    <th>College/Dept</th>
                    <th>Pass Type</th>
                    <th>Events</th>
                    <th>Amount (₹)</th>
                    <th>Status</th>
                    <th>Txn ID</th>
                    <th>Screenshot</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($registrations) > 0): ?>
                    <?php foreach ($registrations as $reg): ?>
                        <tr>
                            <td>#<?= $reg['id'] ?></td>
                            <td><?= htmlspecialchars($reg['team_name']) ?></td>
                            <td>
                                <strong><?= htmlspecialchars($reg['leader_name']) ?></strong><br>
                                <small><?= htmlspecialchars($reg['phone']) ?><br><?= htmlspecialchars($reg['email']) ?></small>
                                <?php if (!empty($reg['member2_phone'])): ?>
                                    <br><small style="color:#00e5ff;">M2 Phone: <?= htmlspecialchars($reg['member2_phone']) ?></small>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($reg['college']) ?><br><small>(<?= htmlspecialchars($reg['department']) ?>)</small></td>
                            <td style="text-transform:uppercase;"><?= htmlspecialchars($reg['pass_type']) ?></td>
                            <td>
                                <?php 
                                    $events = json_decode($reg['selected_events'], true);
                                    if(is_array($events)) {
                                        echo implode(', <br>', array_map('htmlspecialchars', $events));
                                    } else {
                                        echo htmlspecialchars($reg['selected_events']);
                                    }
                                ?>
                            </td>
                            <td>₹<?= $reg['amount'] ?></td>
                            <td>
                                <?php 
                                    $statusClass = 'status-pending';
                                    if ($reg['payment_status'] === 'Completed') $statusClass = 'status-completed';
                                    else if ($reg['payment_status'] === 'Pending Verification') $statusClass = 'status-verifying';
                                ?>
                                <span class="<?= $statusClass ?>"><?= htmlspecialchars($reg['payment_status']) ?></span>
                            </td>
                            <td><?= htmlspecialchars($reg['transaction_id'] ?? 'N/A') ?></td>
                            <td>
                                <?php if (!empty($reg['screenshot_path'])): ?>
                                    <a href="<?= htmlspecialchars($reg['screenshot_path']) ?>" target="_blank" class="screenshot-btn">View Image</a>
                                <?php else: ?>
                                    <span style="color:#555;">No Image</span>
                                <?php endif; ?>
                                
                                <?php if ($reg['payment_status'] === 'Pending Verification'): ?>
                                    <form method="POST" style="margin-top: 5px;">
                                        <input type="hidden" name="verify_id" value="<?= $reg['id'] ?>">
                                        <button type="submit" class="verify-btn" onclick="return confirm('Are you sure you want to approve this payment?');">Approve</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                            <td><small><?= $reg['created_at'] ?></small></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" class="empty-message">No registrations found yet in the database.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
