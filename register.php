<?
require "inc/init.php";
require "classes/phpmailer/Exception.php";
require "classes/phpmailer/PHPMailer.php";
require "classes/phpmailer/SMTP.php";

$data = ['pageTitle' => 'Register an account'];

Dialog::layouts('header-login', $data);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errorEmail = '';
    $email = $_POST['email'];

    $db = require "inc/db.php";

    try {
        //Check mail user exist
        $existingUser  = User::isExist($db, $email);

        if ($existingUser) {
            $errorEmail = "Email already exists";
            Auth::setFlashData('errorEmail', $errorEmail);
        }

        //Check mail user exist and account
        $deletedUser = User::isDelete($db, $email);

        if (empty($errorEmail)) {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $active = sha1(uniqid() . time());
            $create_at = date('Y-m-d H:i:s');

            if ($deletedUser) {
                $addUser = new User($fullname, $email, $phone, $password, $active, $create_at);
                $insertStatus = $addUser->updateUser($db, $deletedUser->id);
            } else {
                $addUser = new User($fullname, $email, $phone, $password, $active, $create_at);
                $insertStatus = $addUser->insertUser($db);
            }

            if ($insertStatus) {
                //Create link active
                $linkActive = 'http://' . $_SERVER['HTTP_HOST'] . '/Web/Team/' . 'active.php?token=' . $active;

                //Send mail
                $subject = "Kích hoạt tài khoản!";
                $content = "Chào " . $_POST['fullname'] . '!<br>';
                $content .= "Vui lòng click vào link dưới đây để kích hoạt tài khoản: <br>";
                $content .= $linkActive . ' <br>';
                $content .= "Trân trọng cảm ơn!";

                $sendMail = Dialog::sendMail($_POST['email'], $subject, $content);
                if ($sendMail) {
                    Auth::setFlashData('msg', 'Registration successful, please check your email to activate your account!');
                    Auth::setFlashData('msg_type', 'success');
                } else {
                    Auth::setFlashData('msg', 'The system is having problems, please try again later!');
                    Auth::setFlashData('msg_type', 'danger');
                }
                header("Location: register.php");
                exit();
            } else {
                Auth::setFlashData('msg', 'Registration failed!');
                Auth::setFlashData('msg_type', 'danger');
                header("Location: register.php");
                exit();
            }
        } else {
            Auth::setFlashData('msg', 'Please check the data again!');
            Auth::setFlashData('msg_type', 'danger');
            header("Location: register.php");
            exit();
        }
    } catch (PDOException $e) {
        header("Location: 404.php");
    }
}
?>

<div class="bg-light">
    <div class="row">
        <div class="col-4 bg-white" style="margin: 25px auto;">
            <h2 class="text-center text-uppercase">Register an account</h2>

            <?
            $msg = Auth::getFlashData('msg');
            $msg_type = Auth::getFlashData('msg_type');
            if (!empty($msg))
                Dialog::getMsg($msg, $msg_type);
            ?>

            <form action="" method="post" id="formRegister">
                <div class="form-group mg-form">
                    <label for="fullname">Fullname</label>
                    <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Ex: Nguyen Van A">
                    <span class="text-danger font-italic error" style="font-style: italic !important;"></span>
                </div>
                <div class="form-group mg-form">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Ex: abcd@gmail.com">
                    <span class="text-danger font-italic error" style="font-style: italic !important;"></span>
                    <p class="text-danger font-italic error-email" style="font-style: italic !important;">
                        <?
                        $errors = Auth::getFlashData('errorEmail');
                        echo !empty($errors) ? $errors : null;
                        ?>
                    </p>
                </div>
                <div class="form-group mg-form">
                    <label for="phone">Phone number</label>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Ex: 0913498756">
                    <span class="text-danger font-italic error" style="font-style: italic !important;"></span>
                </div>
                <div class="form-group mg-form">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                    <span class="text-danger font-italic error" style="font-style: italic !important;"></span>
                </div>
                <div class="form-group mg-form">
                    <label for="password_confirm">Re-password</label>
                    <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Re-password">
                    <span class="text-danger font-italic error" style="font-style: italic !important;"></span>
                </div>
                <button type="submit" class="mg-btn btn btn-primary btn-block">Register</button>
            </form>
        </div>
    </div>
</div>

<? Dialog::layouts('footer') ?>