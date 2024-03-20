<?php

require "../inc/init.php";

$db = require '../inc/db.php';


$id = $_GET['id'] ?? null;

if ($id) {
    $listing = new Listing();
    $result = $listing->deleteById($db, $id);

    if ($result) {
        header('Location: ' . '../managePosts.php');
    } else {
        $_SESSION['error'] = "Deleted failed";
        header('Location: ' . '../404.php');
    }
} else {
    $_SESSION['error'] = "Invalid id";
    header('Location: ' . '../404.php');
}
