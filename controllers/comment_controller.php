<?php

require_once __DIR__ . '/../config/db_config.php';
require_once __DIR__ . '/../models/comment.php';
require_once __DIR__ . '/../utils/session.php';


require_once __DIR__ . '/../assets/vendor/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../assets/vendor/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../assets/vendor/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


//session_start();
require_login();
require_admin();

header('Content-Type: application/json');

function get_user_email_by_comment_id($comment_id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT u.email FROM comments c JOIN users u ON c.user_id = u.id WHERE c.id = ?');
    $stmt->execute([$comment_id]);
    $user = $stmt->fetch();
    return $user['email'] ?? null;
}

function send_email($to, $subject, $message) {
    $phpmailer = new PHPMailer();
    try {
        $phpmailer->isSMTP();
        $phpmailer->Host = 'mail.gc.stud.vts.su.ac.rs';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Username = 'gc';
        $phpmailer->Password = 'svPql5pKYO8zk5K';
        $phpmailer->SMTPSecure = 'tls';
        $phpmailer->Port = 587;
        $phpmailer->setFrom('gc@gc.stud.vts.su.ac.rs', 'Mailer');
        $phpmailer->addAddress($to);
        $phpmailer->isHTML(true);
        $phpmailer->Subject = $subject;
        $phpmailer->Body    = nl2br($message);
        $phpmailer->AltBody = $message;
        $phpmailer->send();
    } catch (Exception $e) {
        error_log("Failed to send email. PHPMailer Error: {$phpmailer->ErrorInfo}");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'approve_comment') {
        $id = $_POST['id'] ?? '';
        if (empty($id)) {
            echo json_encode(['success' => false, 'message' => 'Comment ID is required.']);
            exit();
        }
        $result = Comment::approve_comment($id);
        echo json_encode(['success' => $result]);
    } elseif ($action === 'reject_comment') {
        $id = $_POST['id'] ?? '';
        $reason = $_POST['reason'] ?? '';
        if (empty($id) || empty($reason)) {
            echo json_encode(['success' => false, 'message' => 'Comment ID and reason are required.']);
            exit();
        }
        $result = Comment::reject_comment($id, $reason);
        $user_email = get_user_email_by_comment_id($id);
        if ($result && $user_email) {
            send_email($user_email, "Your comment has been rejected", "Your comment has been rejected for the following reason: $reason");
        }
        echo json_encode(['success' => $result]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
