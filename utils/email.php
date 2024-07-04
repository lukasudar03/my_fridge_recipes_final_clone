<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../assets/vendor/phpmailer/src/Exception.php';
require __DIR__ . '/../assets/vendor/phpmailer/src/PHPMailer.php';
require __DIR__ . '/../assets/vendor/phpmailer/src/SMTP.php';

function send_email($to, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        $phpmailer = new PHPMailer();
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
        $phpmailer->Body    = $body;

        $phpmailer->send();
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


?>
