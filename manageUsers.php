<?
require "inc/init.php";

$data = ['pageTitle' => 'Manage Users'];

Dialog::layouts('header', $data);

if (!Auth::isLoggedIn() || Auth::isLoggedIn() && empty($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

$conn = require "inc/db.php";
$users = User::getAllUsers($conn);
?>

<div class="container">
    <h2 class="text-center mt-5 mb-3">Manage Users</h2>
    <p>
        <a href="addUser.php" class="btn btn-success btn-sm">Add User
            <i class="fa-solid fa-plus"></i>
        </a>
    </p>
    <?
    $msg = Auth::getFlashData('msg');
    $msg_type = Auth::getFlashData('msg_type');
    if (!empty($msg))
        Dialog::getMsg($msg, $msg_type);
    ?>

    <table class="table table-bordered table-striped">
        <thead class="text-center">
            <th>No.</th>
            <th>Fullname</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Edit</th>
            <th>Delete</th>
        </thead>
        <tbody>
        </tbody>
        <tfoot class="text-center table-light">
        </tfoot>
    </table>

    <div class="text-center">
        <button type="button" class="btn btn-outline-primary" id="show" data-type="users">See more...</button>
    </div>
</div>

<? Dialog::layouts('footer') ?>