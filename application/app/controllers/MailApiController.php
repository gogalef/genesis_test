<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;

/**
 * Usd check and subrscribe to updates controller
 */
class MailApiController extends BasicApiController
{

    public function testAction()
    {
        $db_result = ( new Mails )->test();
        return true;
    }
    public function sendAction()
    {

        $usd_rate = ( new Usd )->rate();

        $emails = ( new Mails )->getAllEmails()['data'];
        var_dump($emails);
        die();
        $mail = new PHPMailer(true);
        try {
            // Настройки сервера
            $mail->isSMTP();                                            // Устанавливаем режим отправки через SMTP
            $mail->Host       = 'smtp.example.com';                     // SMTP сервер
            $mail->SMTPAuth   = true;                                   // Включаем SMTP авторизацию
            $mail->Username   = 'your_email@example.com';               // SMTP логин
            $mail->Password   = 'your_password';                        // SMTP пароль
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Включаем шифрование TLS
            $mail->Port       = 587;                                    // TCP порт для TLS

            // Получатели
            $mail->setFrom('from@example.com', 'Mailer');

            // foreach $emails
            $mail->addAddress('recipient@example.com', 'Joe User');     // Добавляем получателя
            // foreach end

            // Содержимое
            $mail->isHTML(true);                                  // Устанавливаем формат email в HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        return true;
    }
}

