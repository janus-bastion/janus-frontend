<?php

require_once '/usr/share/nginx/composer/vendor/autoload.php';

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv::createImmutable('/home/janus-storage/janus-db-connect/');
$dotenv->load();

function generateTotpCode() {
    return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
}

function sendTotpCodeEmail($toEmail, $code) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'imtjanus@gmail.com';
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('imtjanus@gmail.com', 'Janus Admin');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Your Janus verification code';
        $mail->Body = "<b>$code</b> is your Janus verification code.<br>It expires in 5 minutes.<br><br>Best regards,<br>The Janus Team";

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Mail sending error: {$mail->ErrorInfo}");
        return false;
    }
}

