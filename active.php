<?
require "inc/init.php";

$data = ['pageTitle' => 'Active account'];

Dialog::layouts('header-login', $data);

$token = $_GET['token'];

if (!empty($token)) {
    //Check token with db
    $conn = require "inc/db.php";
    $tokenQuery = $conn->query("select id from users where active=:token", ['token' => $token])->fetch(PDO::FETCH_ASSOC);

    if (!empty($tokenQuery)) {
        $userID = $tokenQuery['id'];
        $dataUpdate = [
            'status' => 1,
            'active' => NULL
        ];

        $updateStatus = $conn->update('users', $dataUpdate, "id=$userID");

        if ($updateStatus) {
            Auth::setFlashData('msg', "Account activation successful, you can log in now!");
            Auth::setFlashData('msg_type', "success");
        } else {
            Auth::setFlashData('msg', "Account activation failed, please contact administrator!");
            Auth::setFlashData('msg_type', "danger");
        }
        header("Location: login.php");
        exit();
    } else
        Dialog::getMsg("Link does not exist or has expired!", 'danger');
} else
    Dialog::getMsg("Link does not exist or has expired!", 'danger');
?>

<? Dialog::layouts('footer') ?>