<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

function send2FACode(string $email, int $code): bool {
    $mail = new PHPMailer(true);

    try {
        // Настройки SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'alexandrkushnir02@gmail.com'; 
        $mail->Password   = 'ugor qddv slpd fbcg';  
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // От кого и кому
        $mail->setFrom('alexandrkushnir02@gmail.com', 'Auth system');
        $mail->addAddress($email);

        // Контент письма
        $mail->isHTML(true);
        $mail->Subject = 'Your 2FA verification code';
        $mail->Body    = "
            <h2>Your verification code:</h2>
            <p style='font-size:22px;font-weight:bold;'>$code</p>
            <p>This code is valid for 5 minutes.</p>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
         die("Mailer error: " . $mail->ErrorInfo);
        error_log("Mailer error: " . $mail->ErrorInfo);
        return false;
    }
}
