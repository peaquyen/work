<?

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Dialog
{
    public static function layouts($layoutName = "header", $data = [])
    {
        if (file_exists(__DIR__ . "/../inc/" . $layoutName . ".php"))
            require_once __DIR__ . "/../inc/" . $layoutName . ".php";
    }

    public static function sendMail($to, $subject, $content)
    {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                       //Enable verbose debug output
            $mail->isSMTP();                                          //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                 //Enable SMTP authentication
            $mail->Username   = 'dynlinh222@gmail.com';               //SMTP username
            $mail->Password   = 'loerhiwbkrsjzhsg';                   //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          //Enable implicit TLS encryption
            $mail->Port       = 465;                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('dynlinh222@gmail.com', 'Alice Dinh');
            $mail->addAddress($to);     //Add a recipient


            //Content
            $mail->CharSet = "UTF-8";
            $mail->isHTML(true);                //Set email format to HTML
            $mail->Subject = $subject;          //Title
            $mail->Body    = $content;          //Content

            //PHPMailer SSL(Secure Sockets Layer) certificate verify failed
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                )
            );

            $sendMail = $mail->send();
            if ($sendMail)
                return $sendMail;

            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    //Error message
    public static function getMsg($msg, $type = 'success')
    {
        echo '<div class="alert alert-' . $type . '">' . $msg . '</div>';
    }
}
