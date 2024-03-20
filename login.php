<?
require "inc/init.php";

$data = ['pageTitle' => 'Login'];

Dialog::layouts('header-login', $data);

if (Auth::isLoggedIn()) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty(trim($_POST['email'])) && !empty(trim($_POST['password']))) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        if ($email == ADMIN)
            Auth::setSession('admin', 'admin');

        //Query to get info user by email
        $conn = require "inc/db.php";

        $user = new User();
        $userID = $user::isExist($conn, $email);

        if ($userID) {
            if ($user::authenticate($conn, $email, $password)) {
                // Check if user is already logged in 
                $login = new Login();
                $login->checkLogin($conn, $userID);

                // Create token login
                $tokenLogin = sha1(uniqid() . time());
                $login = new Login($userID, $tokenLogin, date('Y-m-d H:i:s'));
                $insertStatus = $login->insertDataUserInLogin($conn);

                if ($insertStatus) {
                    Auth::setSession('login', $tokenLogin);
                    Auth::setSession('user_id', $userID);
                    header("Location: index.php");
                    exit();
                } else {
                    Auth::setFlashData('msg', 'Unable to log in, please try again later.');
                    Auth::setFlashData('msg_type', 'danger');
                }
            } else {
                Auth::setFlashData('msg', 'Incorrect password.');
                Auth::setFlashData('msg_type', 'danger');
            }
        } else {
            Auth::setFlashData('msg', 'Email does not exist.');
            Auth::setFlashData('msg_type', 'danger');
        }
    } else {
        Auth::setFlashData('msg', 'Please enter email and password.');
        Auth::setFlashData('msg_type', 'danger');
    }
    header("Location: login.php");
    exit();
}

?>

<div class="bg-light">
    <div class="row">
        <div class="col-4 bg-white" style="margin: 50px auto;">
            <h2 class="text-center text-uppercase">Login</h2>

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
                <div class="form-group mg-form">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                </div>
                <button type="submit" class="mg-btn btn btn-primary btn-block">Login</button>
                <br>
                <p class="text-center"> <a href="forget.php">Forgot password</a></p>

            </form>
        </div>
    </div>
</div>

<? Dialog::layouts('footer') ?>