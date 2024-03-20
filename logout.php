<?
require "inc/init.php";

if (Auth::isLoggedIn()) {
    $token = Auth::getSession('login');
    $database = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    $database->delete('login', "token='$token'");

    Auth::deleteSession('login');
    Auth::deleteSession('user_id');

    if (isset($_SESSION['admin']))
        Auth::deleteSession('admin');

    header("Location: index.php");
    exit();
}
