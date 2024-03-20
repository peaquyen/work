<?
require "inc/init.php";
$db = require "inc/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$page = $_GET['page'] ?? 1;
$limit = 2;
$offset = ($page - 1) * $limit;

if (isset($data['type']) && $data['type'] == 'posts') {
    $listings = Listing::getPagingByUserId($db, $limit, $offset, $_SESSION['user_id']);

    foreach ($listings as $l) {
        $l->company = Company::getById($db, $l->company_id);
        unset($l->company_id);
    }

    echo json_encode($listings);
}

if (isset($data['type']) && $data['type'] == 'users') {
    $users = User::getPaging($db, $limit, $offset);

    echo json_encode($users);
}
