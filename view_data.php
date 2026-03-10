<?php
session_start();
require_once 'config.php';
require_once 'mailer.php';

// --- 1. PREVENT BROWSER CACHING SECURELY ---
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');

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

// --- 3. VERIFY LOGIN STATUS ---
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

try {
    $pdo = getDBConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Handle Verification Approval
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_id'])) {
        $verify_id = (int)$_POST['verify_id'];
        
        // 1. Fetch details BEFORE updating for the email
        $userStmt = $pdo->prepare("SELECT * FROM registrations WHERE id = :id");
        $userStmt->execute(['id' => $verify_id]);
        $user = $userStmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['payment_status'] !== 'Completed') {
            // 2. Update Status
            $updateStmt = $pdo->prepare("UPDATE registrations SET payment_status = 'Completed' WHERE id = :id");
            $updateStmt->execute(['id' => $verify_id]);

            // 3. Send Emails
            $admin_email = ADMIN_EMAIL;
            $events = json_decode($user['selected_events'], true);
            $event_list = "<ul>";
            if (is_array($events)) {
                foreach ($events as $event) {
                    if (is_array($event)) {
                        foreach ($event as $e) $event_list .= "<li>" . htmlspecialchars($e) . "</li>";
                    } else {
                        $event_list .= "<li>" . htmlspecialchars($event) . "</li>";
                    }
                }
            }
            $event_list .= "</ul>";

            $subject_user = "Registration Verified! - THIGAZH 2K26";
            $body_user = "<p>Congratulations <b>{$user['leader_name']}</b>!</p>
                         <p>Your payment for <b>Team: {$user['team_name']}</b> has been successfully verified by our team.</p>
                         <div class='event-list'>
                            <p><strong>Your Confirmed Events:</strong></p>
                            $event_list
                         </div>
                         <p><b>Pass Type:</b> <span class='highlight'>" . strtoupper($user['pass_type']) . " Pass</span></p>
                         <p>Please keep this email handy as your digital confirmation. We are excited to see your team at the event!</p>";
            
            $subject_admin = "REGISTRATION APPROVED: {$user['team_name']}";
            $body_admin = "<p>You have successfully approved the registration for <b>{$user['team_name']}</b>.</p>
                          <div class='event-list'>
                            <p><b>Final Details:</b></p>
                            <ul>
                                <li><b>Team Name:</b> {$user['team_name']}</li>
                                <li><b>Leader:</b> {$user['leader_name']} ({$user['email']})</li>
                                <li><b>Events Confirmed:</b> $event_list</li>
                                <li><b>Status:</b> <span class='highlight'>Completed (Verified)</span></li>
                            </ul>
                          </div>";

            sendThigazhMail($user['email'], $user['leader_name'], $subject_user, $body_user);
            sendThigazhMail($admin_email, "Admin - THIGAZH", $subject_admin, $body_admin);
        }
        
        // Refresh the page to show the update
        header("Location: view_data.php");
        exit;
    }

    // Handle Export to Excel
    if (isset($_GET['export']) && $_GET['export'] == 'excel') {
        // Prevent deprecation warnings from breaking the Excel file
        ini_set('display_errors', 0);
        error_reporting(0);
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="thigazh_registrations_'.date('Y-m-d').'.xls"');
        // Handle Search Configure for Export
        $export_search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $export_status = isset($_GET['status_filter']) ? $_GET['status_filter'] : '';
        
        $export_query = "SELECT * FROM registrations WHERE 1=1";
        $export_params = [];
        
        if ($export_search !== '') {
            $export_query .= " AND (id LIKE :search OR pass_type LIKE :search OR team_name LIKE :search OR leader_name LIKE :search OR college LIKE :search OR phone LIKE :search OR email LIKE :search)";
            $export_params[':search'] = "%$export_search%";
        }
        
        if ($export_status !== '') {
            $export_query .= " AND payment_status = :status";
            $export_params[':status'] = $export_status;
        }
        
        $export_query .= " ORDER BY created_at DESC";
        $exportStmt = $pdo->prepare($export_query);
        $exportStmt->execute($export_params);
        // Output an HTML table that Excel will interpret perfectly
        echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
        echo '<head>';
        echo '<!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Registrations</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->';
        echo '<style> .text-cell { mso-number-format:"\@"; } </style>';
        echo '</head><body>';
        echo '<table border="1">';
        echo '<tr>
                <th style="background-color:#000000; color:#ffffff;">ID</th>
                <th style="background-color:#000000; color:#ffffff;">Team Name</th>
                <th style="background-color:#000000; color:#ffffff;">Leader Name</th>
                <th style="background-color:#000000; color:#ffffff;">Leader Phone</th>
                <th style="background-color:#000000; color:#ffffff;">Leader Email</th>
                <th style="background-color:#000000; color:#ffffff;">Member 2</th>
                <th style="background-color:#000000; color:#ffffff;">Member 2 Phone</th>
                <th style="background-color:#000000; color:#ffffff;">Member 3</th>
                <th style="background-color:#000000; color:#ffffff;">Member 4</th>
                <th style="background-color:#000000; color:#ffffff;">College</th>
                <th style="background-color:#000000; color:#ffffff;">Department</th>
                <th style="background-color:#000000; color:#ffffff;">Pass Type</th>
                <th style="background-color:#000000; color:#ffffff;">Events</th>
                <th style="background-color:#000000; color:#ffffff;">Amount</th>
                <th style="background-color:#000000; color:#ffffff;">Payment Status</th>
                <th style="background-color:#000000; color:#ffffff;">Transaction ID</th>
                <th style="background-color:#000000; color:#ffffff;">Registration Date</th>
              </tr>';
              
        while ($row = $exportStmt->fetch(PDO::FETCH_ASSOC)) {
            $events = json_decode($row['selected_events'], true);
            $events_str = is_array($events) ? implode(', ', $events) : $row['selected_events'];
            
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . htmlspecialchars($row['team_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['leader_name']) . '</td>';
            echo '<td class="text-cell">' . htmlspecialchars($row['phone']) . '</td>';
            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
            echo '<td>' . htmlspecialchars($row['member2']) . '</td>';
            echo '<td class="text-cell">' . htmlspecialchars($row['member2_phone']) . '</td>';
            echo '<td>' . htmlspecialchars($row['member3']) . '</td>';
            echo '<td>' . htmlspecialchars($row['member4']) . '</td>';
            echo '<td>' . htmlspecialchars($row['college']) . '</td>';
            echo '<td>' . htmlspecialchars($row['department']) . '</td>';
            echo '<td style="text-transform:uppercase;">' . htmlspecialchars($row['pass_type']) . '</td>';
            echo '<td>' . htmlspecialchars($events_str) . '</td>';
            echo '<td>₹' . $row['amount'] . '</td>';
            echo '<td>' . htmlspecialchars($row['payment_status']) . '</td>';
            echo '<td class="text-cell">' . htmlspecialchars($row['transaction_id']) . '</td>';
            echo '<td>' . $row['created_at'] . '</td>';
            echo '</tr>';
        }
        
        echo '</table></body></html>';
        exit;
    }

    // Handle Export to Excel
    // Handle SQL Database Backup
    if (isset($_GET['export']) && $_GET['export'] == 'sql') {
        // Prevent errors breaking the SQL download
        ini_set('display_errors', 0);
        error_reporting(0);
        
        $backup_file = "thigazh_db_backup_" . date('Y-m-d_H-i-s') . ".sql";
        $command = "mysqldump --user={$user} --password={$pass} --host={$host} {$dbname} > /tmp/{$backup_file} 2>/dev/null";
        system($command);
        
        if (file_exists("/tmp/{$backup_file}")) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($backup_file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize("/tmp/{$backup_file}"));
            readfile("/tmp/{$backup_file}");
            unlink("/tmp/{$backup_file}"); // Clean up
            exit;
        } else {
            echo "<script>alert('Failed to generate database backup. Ensure mysqldump is installed and accessible.'); window.history.back();</script>";
            exit;
        }
    }
    
    // Handle Deletion
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
        $delete_id = (int)$_POST['delete_id'];
        $delStmt = $pdo->prepare("DELETE FROM registrations WHERE id = :id");
        $delStmt->execute(['id' => $delete_id]);
        
        header("Location: view_data.php");
        exit;
    }

    // Handle Search and Filter
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : '';
    
    $query = "SELECT * FROM registrations WHERE 1=1";
    $params = [];
    
    if ($search !== '') {
        $query .= " AND (id LIKE :search OR pass_type LIKE :search OR team_name LIKE :search OR leader_name LIKE :search OR college LIKE :search OR phone LIKE :search OR email LIKE :search)";
        $params[':search'] = "%$search%";
    }
    
    if ($status_filter !== '') {
        $query .= " AND payment_status = :status";
        $params[':status'] = $status_filter;
    }
    
    $query .= " ORDER BY created_at DESC";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    showErrorPage("Database Error", $e->getMessage());
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
            background-color: #0a0a23;
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
        
        .controls-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .search-form {
            display: flex;
            gap: 0.5rem;
        }
        .search-input, .status-select {
            padding: 0.5rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid #444;
            color: #fff;
            border-radius: 4px;
            font-family: inherit;
        }
        .search-input:focus, .status-select:focus {
            outline: none;
            border-color: #00e5ff;
        }
        .btn-action {
            padding: 0.5rem 1rem;
            background: #00e5ff;
            color: #000;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            font-family: var(--font-ui);
            text-transform: uppercase;
            text-decoration: none;
            font-size: 0.8rem;
        }
        .btn-action:hover { background: #fff; }
        .btn-export { background: #ffcc00; }
    </style>
</head>
<body>
    <h1 class="glitch" data-text="Admin Dashboard">Admin Dashboard</h1>

    <div class="controls-container">
        <form class="search-form" method="GET" action="view_data.php">
            <input type="text" name="search" class="search-input" placeholder="Search pass, ID, team, leader..." value="<?= htmlspecialchars($search) ?>">
            <select name="status_filter" class="status-select">
                <option value="">All Statuses</option>
                <option value="Pending" <?= $status_filter === 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Pending Verification" <?= $status_filter === 'Pending Verification' ? 'selected' : '' ?>>Pending Verification</option>
                <option value="Completed" <?= $status_filter === 'Completed' ? 'selected' : '' ?>>Completed</option>
            </select>
            <button type="submit" class="btn-action">Filter</button>
            <?php if ($search !== '' || $status_filter !== ''): ?>
                <a href="view_data.php" class="btn-action" style="background: #ff003c; color: #fff;">Clear</a>
            <?php endif; ?>
        </form>
        
        <?php
            // Build the export URL with current filter parameters
            $export_params = ['export' => 'excel'];
            if ($search !== '') $export_params['search'] = $search;
            if ($status_filter !== '') $export_params['status_filter'] = $status_filter;
            $export_url = 'view_data.php?' . http_build_query($export_params);
        ?>
        <a href="add_data.php" class="btn-action" style="background: #ff003c; color: #fff;">+ Add Record</a>
        <a href="<?= htmlspecialchars($export_url) ?>" class="btn-action btn-export" style="background: #00ff88;">Export Excel</a>
        <a href="view_data.php?export=sql" class="btn-action" style="background: #00e5ff; color: #000;">Backup SQL</a>
        <a href="logout.php" class="btn-action" style="background: #333; color: #fff;">Logout</a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Team Name</th>
                    <th>Team Details</th>
                    <th>College/Dept</th>
                    <th>Pass Type</th>
                    <th>Events</th>
                    <th>Amount (₹)</th>
                    <th>Status</th>
                    <th>Txn ID</th>
                    <th>Screenshot</th>
                    <th>Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($registrations) > 0): ?>
                    <?php foreach ($registrations as $reg): ?>
                        <tr>
                            <td>#<?= $reg['id'] ?></td>
                            <td><?= htmlspecialchars($reg['team_name']) ?></td>
                            <td>
                                <strong>L: </strong><?= htmlspecialchars($reg['leader_name']) ?> <small>(<?= htmlspecialchars($reg['phone']) ?>, <?= htmlspecialchars($reg['email']) ?>)</small><br>
                                <?php if (!empty($reg['member2'])): ?>
                                    <strong>M2: </strong><?= htmlspecialchars($reg['member2']) ?> 
                                    <?php if (!empty($reg['member2_phone'])): ?><small>(<?= htmlspecialchars($reg['member2_phone']) ?>)</small><?php endif; ?><br>
                                <?php endif; ?>
                                <?php if (!empty($reg['member3'])): ?>
                                    <strong>M3: </strong><?= htmlspecialchars($reg['member3']) ?><br>
                                <?php endif; ?>
                                <?php if (!empty($reg['member4'])): ?>
                                    <strong>M4: </strong><?= htmlspecialchars($reg['member4']) ?><br>
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
                            <td>
                                <a href="edit_data.php?id=<?= $reg['id'] ?>" class="verify-btn" style="background: #ffcc00; color: #000; margin-bottom: 5px; display: block; text-align: center;">Edit</a>
                                <form method="POST" style="margin: 0;">
                                    <input type="hidden" name="delete_id" value="<?= $reg['id'] ?>">
                                    <button type="submit" class="verify-btn" style="background: #ff003c; color: #fff; width: 100%;" onclick="return confirm('Are you sure you want to delete this registration? This cannot be undone.');">Delete</button>
                                </form>
                            </td>
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
