<?
require "inc/init.php";

if (!Auth::isLoggedIn() || Auth::isLoggedIn() && empty($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

$userID = $_GET['id'];
$db = require "inc/db.php";

if (!empty($userID)) {
    $userDetail = $db->query("select * from users where id=:userID", ['userID' => $userID], 'User')->fetch();

    if (!empty($userDetail)) {
        $deleteToken = $db->delete('login', "user_id = $userID");

        if ($deleteToken) {
            $dataUpdate = ['status' => 0];

            $updateStatus = $db->update('users', $dataUpdate, "id=$userID");
            if ($updateStatus) {
                Auth::setFlashData('msg', 'Successfully deleted user!');
                Auth::setFlashData('msg_type', 'success');
            } else {
                Auth::setFlashData('msg', 'System error please try again later');
                Auth::setFlashData('msg_type', 'danger');
            }
        }
    } else {
        Auth::setFlashData('msg', 'User does not exist!');
        Auth::setFlashData('msg_type', 'danger');
    }
} else {
    Auth::setFlashData('msg', 'Link does not exist!');
    Auth::setFlashData('msg_type', 'danger');
}

header("Location: manageUsers.php");
exit();
