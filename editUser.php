<?
require "inc/init.php";

$data = ['pageTitle' => 'Edit User'];

Dialog::layouts('header', $data);

if (!Auth::isLoggedIn() || Auth::isLoggedIn() && empty($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

$userID = $_GET['id'];
$db = require "inc/db.php";

$user = User::getById($db, $userID);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $fullname = ($_POST['fullname'] == '') ? $user->fullname : $_POST['fullname'];
    $email = ($_POST['email'] == '') ? $user->email : $_POST['email'];
    $phone = ($_POST['phone'] == '') ? $user->phone : $_POST['phone'];
    $status = $_POST['status'];

    // check email in db
    if ($email) {
        $id = User::isEmail($db, $email, $userID);
        if ($id)
            $errors['email']['unique']  = "Email already exists";
    }

    // check current password is correct
    // if (!empty($_POST['current_password']))
    //     if (!password_verify($_POST['current_password'], $user->password))
    //         $errors['current_password'] = "The current password is incorrect";


    //Validate password
    if (!empty($_POST['password'])) {
        $password = $_POST['password'];
        $pass_pattern = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";
        if (!preg_match($password, $pass_pattern))
            $errors['password']['rules'] = "Password must contain at least 1 uppercase letter, 1 lowercase letter and 1 number, and at least 8 characters";
        //Validate password_confirm
        if (empty($_POST['password_confirm']))
            $errors['password_confirm']['required'] = "Re-password required";
        else {
            if ($_POST['password'] != $_POST['password_confirm'])
                $errors['password_confirm']['match'] = "The re-password does not match";
        }
    }

    if (empty($errors)) {
        if (!empty($_POST['password']))
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        else
            $password = $user->password;


        $user = new User($fullname, $email, $phone, $password, $user->active, date('Y-m-d H:i:s'), $status);
        $updateStatus = $user->updateUser($db, $userID);

        if ($updateStatus) {
            Auth::setFlashData('msg', 'Edit user successfully!');
            Auth::setFlashData('msg_type', 'success');
        } else {
            Auth::setFlashData('msg', 'System error please try again later!');
            Auth::setFlashData('msg_type', 'danger');
        }
    } else {
        Auth::setFlashData('msg', 'Please check the data again!');
        Auth::setFlashData('msg_type', 'danger');
        Auth::setFlashData('errors', $errors);
    }
    header("Location: editUser.php?id=" . $userID);
    exit();
}
?>


<div class="bg-light">
    <div class="row">
        <div class="col-4  bg-white" style="margin: 25px auto;">
            <h2 class="text-center text-uppercase">Edit User</h2>

            <?
            $msg = Auth::getFlashData('msg');
            $msg_type = Auth::getFlashData('msg_type');
            if (!empty($msg))
                Dialog::getMsg($msg, $msg_type);
            ?>

            <form action="" method="post" id="formEditUser">
                <div class="form-group mg-form">
                    <label for="fullname">Fullname</label>
                    <input type="text" name="fullname" id="fullname" class="form-control" placeholder="<? echo $user->fullname ?>">
                    <span class="text-danger font-italic error" style="font-style: italic !important;"></span>
                </div>
                <div class="form-group mg-form">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="<? echo $user->email ?>">
                    <span class="text-danger font-italic error" style="font-style: italic !important;"></span>
                    <p class="text-danger font-italic" style="font-style: italic !important;">
                        <?php
                        $errors = Auth::getFlashData('errors');
                        echo !empty($errors['email']['unique']) ? $errors['email']['unique'] : null;
                        ?>
                    </p>
                </div>
                <div class="form-group mg-form">
                    <label for="phone">Phone number</label>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="<? echo $user->phone ?>">
                    <span class="text-danger font-italic error" style="font-style: italic !important;"></span>
                </div>

                <!-- <div class="form-group mg-form">
                    <label for="current_password">Current Password</label>
                    <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Current Password" autocomplete="current-password">
                    <span class="text-danger font-italic error" style="font-style: italic !important;"> 
                        <? echo !empty($errors['current_password']) ? ($errors['current_password']) : null; ?>
                    </span>
                </div> -->

                <div class="form-group mg-form">
                    <label for="password">New Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                    <span class="text-danger font-italic" style="font-style: italic !important;">
                        <? echo !empty($errors['password']) ? reset($errors['password']) : null; ?>
                    </span>
                </div>
                <div class="form-group mg-form">
                    <label for="password_confirm">Re-password</label>
                    <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Re-password">
                    <span class="text-danger font-italic" style="font-style: italic !important;">
                        <? echo !empty($errors['password_confirm']) ? reset($errors['password_confirm']) : null; ?>
                    </span>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="0" <?php if ($user->status == 0) echo 'selected'; ?>>Not activated</option>
                        <option value="1" <?php if ($user->status == 1) echo 'selected'; ?>>Activated</option>
                    </select>
                </div>
                <button type="submit" class="mg-btn btn btn-primary btn-block mt-3">Edit User</button>
                <a href="manageUsers.php" class="mg-btn btn btn-outline-secondary btn-block">Back</a>
            </form>
        </div>
    </div>
</div>

<? Dialog::layouts('footer') ?>