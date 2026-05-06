<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/PHPMailer/src/Exception.php';
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';

function inviaEmail($destinatario, $oggetto, $messaggioHtml) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'email@gmail.com';
        $mail->Password   = 'nun ce prova';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('email@gmail.com', 'Volontariato');
        $mail->addAddress($destinatario);

        $mail->isHTML(true);
        $mail->Subject = $oggetto;
        $mail->Body = $messaggioHtml;

        $mail->send();
        return true;

    } catch (Exception $e) {
        return $mail->ErrorInfo;
    }
}
