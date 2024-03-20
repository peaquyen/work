<?
require "inc/init.php";
require "classes/phpmailer/Exception.php";
require "classes/phpmailer/PHPMailer.php";
require "classes/phpmailer/SMTP.php";

$data = ['pageTitle' => 'Forgot password'];

Dialog::layouts('header-login', $data);

//Check login status
if (Auth::isLoggedIn()) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    if (!empty($email)) {
        $conn = require "inc/db.php";
        $queryUser = $conn->query("select id, fullname from users where email=:email", ['email' => $email])->fetch(PDO::FETCH_ASSOC);

        if (!empty($queryUser)) {
            $userID = $queryUser['id'];

            //Create forget token
            $forgetToken = sha1(uniqid() . time());
            $dataUpdate = ['forgetPassword' => $forgetToken];
            $updateStatus = $conn->update('users', $dataUpdate, "id=$userID");

            if ($updateStatus) {
                //link reset, recover password
                $linkReset = 'http://' . $_SERVER['HTTP_HOST'] . '/Web/Team/' . 'reset.php?token=' . $forgetToken;

                //Send mail
                $subject = "Khôi phục mật khẩu";
                $content = "Chào " . $queryUser['fullname'] . '!<br>';
                $content .= "Vui lòng click vào link dưới đây để khôi phục mật khẩu: <br>";
                $content .= $linkReset . ' <br>';
                $content .= "Trân trọng cảm ơn!";

                $sendMail = Dialog::sendMail($email, $subject, $content);

                if ($sendMail) {
                    Auth::setFlashData('msg', 'Please check your email to reset your password!');
                    Auth::setFlashData('msg_type', 'success');
                } else {
                    Auth::setFlashData('msg', 'System error please try again later!');
                    Auth::setFlashData('msg_type', 'danger');
                }
            } else {
                Auth::setFlashData('msg', 'System error please try again later!');
                Auth::setFlashData('msg_type', 'danger');
            }
        } else {
            Auth::setFlashData('msg', 'The email does not exist in the system.');
            Auth::setFlashData('msg_type', 'danger');
        }
    } else {
        Auth::setFlashData('msg', 'Please enter email');
        Auth::setFlashData('msg_type', 'danger');
    }
    header("Location: forget.php");
    exit();
}
?>

<div class="bg-light">
    <div class="row">
        <div class="col-4  bg-white" style="margin: 50px auto;">
            <h2 class="text-center text-uppercase">Forgot password</h2>

            <?
            $msg = Auth::getFlashData('msg');
            $msg_type = Auth::getFlashData('msg_type');
            if (!empty($msg))
                Dialog::getMsg($msg, $msg_type);
            ?>

            <form action="" method="post">
                <div class="form-group mg-form">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                </div>
                <button type="submit" class="mg-btn btn btn-primary btn-block">Send</button>
            </form>
        </div>
    </div>
</div>

<? Dialog::layouts('footer') ?>