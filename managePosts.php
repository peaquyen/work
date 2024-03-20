<?
require "inc/init.php";

$data = ['pageTitle' => 'Manage Posts'];

Dialog::layouts('header', $data);

if (!Auth::isLoggedIn() || Auth::isLoggedIn() && isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

?>

<div class="container">
    <h2 class="text-center mt-5 mb-3">Manage Posts</h2>
    <p>
        <a href="post-job.php" class="btn btn-success btn-sm">Add Post
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
            <th width="5%">No.</th>
            <th>Company</th>
            <th width="30%">Title Job</th>
            <th width="10%">Salary</th>
            <th width="5%">Detail</th>
            <th width="5%">Edit</th>
            <th width="5%">Delete</th>
        </thead>
        <tbody>
        </tbody>
        <tfoot class="text-center table-light">
        </tfoot>
    </table>

    <div class="text-center">
        <button type="button" class="btn btn-outline-primary" id="show" data-type="posts">See more...</button>
    </div>
</div>

<? Dialog::layouts('footer') ?>