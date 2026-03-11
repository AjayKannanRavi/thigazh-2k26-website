<?php
// mailer.php
require_once 'config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Require PHPMailer files using absolute paths
$phpmailer_base = __DIR__ . '/PHPMailer/src/';
if (!file_exists($phpmailer_base . 'Exception.php')) {
    die("PHPMailer files not found in: " . $phpmailer_base);
}
require_once $phpmailer_base . 'Exception.php';
require_once $phpmailer_base . 'PHPMailer.php';
require_once $phpmailer_base . 'SMTP.php';

/**
 * Returns a human-readable name for an event ID.
 */
function getEventDisplayName($eventId) {
    $events = [
        'codeathon' => 'Codeathon 💻 (Day 1)',
        'project_expo' => 'Project Expo 🚀 (Day 1)',
        'mindsynth' => 'MindSynth 🧠 (Day 1)',
        'console_app' => 'Console-Based App 🖥️ (Day 2)',
        'arachnid' => 'Arachnid Cipher 🕷️ (Day 2)'
    ];
    return isset($events[$eventId]) ? $events[$eventId] : ucfirst(str_replace('_', ' ', $eventId));
}

/**
 * Returns a professional HTML template for Thigazh 2K26 emails.
 */
function getThigazhEmailTemplate($title, $content) {
    return "
    <html>
    <head>
        <style>
            body { font-family: 'Montserrat', 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #050505; color: #dddddd; margin: 0; padding: 0; line-height: 1.6; }
            .container { max-width: 600px; margin: 20px auto; background-color: #0d0d0d; border: 2px solid #ff003c; box-shadow: 0 0 20px rgba(255, 0, 60, 0.3); overflow: hidden; border-radius: 8px; }
            .header { background: #1a0000; padding: 30px; text-align: center; border-bottom: 2px solid #ff003c; }
            .header h1 { color: #ff003c; font-family: 'Orbitron', sans-serif; text-transform: uppercase; margin: 0; font-size: 28px; text-shadow: 0 0 10px rgba(255, 0, 60, 0.5); letter-spacing: 2px; }
            .content { padding: 40px; }
            .content h2 { color: #ffffff; font-size: 20px; border-bottom: 1px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
            .content p { margin: 0 0 15px; font-size: 15px; color: #bbbbbb; }
            .event-list { background: rgba(255, 0, 60, 0.05); border-left: 4px solid #ff003c; padding: 20px; margin: 25px 0; border-radius: 4px; }
            .event-list ul { margin: 0; padding-left: 20px; }
            .event-list li { margin-bottom: 8px; color: #ffffff; font-weight: 500; list-style-type: square; }
            .footer { background-color: #000000; padding: 25px; text-align: center; font-size: 13px; color: #888; border-top: 1px solid #222; }
            .btn { display: inline-block; padding: 12px 25px; background-color: #ff003c; color: #ffffff !important; text-decoration: none; border-radius: 4px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; margin-top: 20px; }
            .highlight { color: #ff003c; font-weight: bold; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>THIGAZH 2K26</h1>
            </div>
            <div class='content'>
                <h2>$title</h2>
                <div style='color: #ddd;'>$content</div>
            </div>
            <div class='footer'>
                <p>&copy; 2026 THIGAZH 2K26. All rights reserved.</p>
                <p>An Innovation Driven Technology Festival</p>
            </div>
        </div>
    </body>
    </html>";
}

function sendThigazhMail($to_email, $to_name, $subject, $body_content, $is_html_content = true) {
    file_put_contents('mail_log.txt', "\n" . date('Y-m-d H:i:s') . " [CALL] sendThigazhMail triggered for: $to_email\n", FILE_APPEND);
    $mail = new PHPMailer(true);
    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST; 
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER; 
        $mail->Password   = SMTP_PASS; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = SMTP_PORT;

        // Debugging
        $mail->SMTPDebug = 0; // Disable in-browser debug, log to file instead

        // Recipients
        $mail->setFrom(SMTP_USER, 'THIGAZH 2K26'); 
        $mail->addAddress($to_email, $to_name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        
        // Wrap the content in our professional template
        $mail->Body = getThigazhEmailTemplate($subject, $body_content);

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mail Error: {$mail->ErrorInfo}");
        file_put_contents('mail_log.txt', date('Y-m-d H:i:s') . " [ERROR] " . $e->getMessage() . "\n", FILE_APPEND);
        return false;
    }
}
?>
