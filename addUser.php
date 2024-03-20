<?
require "inc/init.php";

$data = ['pageTitle' => 'Add User'];

Dialog::layouts('header', $data);

if (!Auth::isLoggedIn() || Auth::isLoggedIn() && empty($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errorEmail = '';
    $email = $_POST['email'];

    $db = require "inc/db.php";

    try {
        $user = new User();
        $stmt = $user->isExist($db, $email);

        if ($stmt) {
            $errorEmail = "Email already exists";
            Auth::setFlashData('errorEmail', $errorEmail);
        }
    } catch (PDOException $e) {
        header("Location: 404.php");
    }

    if (empty($errorEmail)) {
        $dataInsert = [
            'fullname' => $_POST['fullname'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'status' => $_POST['status'],
            'create_at' => date('Y-m-d H:i:s')
        ];

        $user = new User($dataInsert['fullname'], $dataInsert['email'], $dataInsert['phone'], $dataInsert['password'], 
                        1, $dataInsert['create_at'], $dataInsert['status']);
        $insertStatus = $user->insertUser($db);

        if ($insertStatus) {
            Auth::setFlashData('msg', 'Successfully added new user!');
            Auth::setFlashData('msg_type', 'success');
            header("Location: manageUsers.php");
            exit();
        } else {
            Auth::setFlashData('msg', 'System error please try again later!');
            Auth::setFlashData('msg_type', 'danger');
            header("Location: addUser.php");
            exit();
        }
    } else {
        Auth::setFlashData('msg', 'Please check the data again!');
        Auth::setFlashData('msg_type', 'danger');
        header("Location: addUser.php");
        exit();
    }
}
?>


<div class="bg-light">
    <div class="row">
        <div class="col-4 bg-white" style="margin: 25px auto;">
            <h2 class="text-center text-uppercase">Add User</h2>

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
                        <?php
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
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="0">Not activated</option>
                        <option value="1">Activated</option>
                    </select>
                </div>
                <button type="submit" class="mg-btn btn btn-primary mt-3">Add User</button>
                <a href="manageUsers.php" class="mg-btn btn btn-outline-secondary">Back</a>
            </form>
        </div>
    </div>
</div>


<? Dialog::layouts('footer') ?>