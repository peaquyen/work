<?
require "inc/init.php";

$data = ['pageTitle' => 'Job Details'];

Dialog::layouts('header', $data);

if (!Auth::isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;
$db = require 'inc/db.php';

$listing = new Listing();
$listing = Listing::getById($db, $id);

$company = new Company();
$company = Company::getById($db, $listing->company_id);
?>

<div class="container mt-3">
    <div class="rounded-lg shadow bg-white p-4">
        <div class="d-flex justify-content-between align-items-center">
            <a class="p-2 text-primary text-decoration-none" href="index.php">
                <i class="fa fa-arrow-alt-circle-left"></i>
                Back To Listings
            </a>
            <? if (isset($_SESSION['user_id'])) : ?>
                <? if ($_SESSION['user_id'] == $listing->user_id) : ?>
                    <div class="d-flex gap-4 ms-4">
                        <a href="editPost.php?id=<? echo $id; ?>" class="btn btn-primary rounded px-4 py-2">Edit</a>
                        <form method="POST" data-id-listing="<? echo $id ?>">
                            <a href="./ajax/deletePost.php?id=<? echo $id; ?>" class="btn btn-outline-danger rounded px-4 py-2">Delete</a>
                        </form>
                    </div>
                <? endif; ?>
            <? endif; ?>
        </div>
        <div class="p-2">
            <h2><? echo $listing->title ?></h2>
            <p class="text-muted mt-2">
                <? echo $listing->description ?>
            </p>
            <ul class="bg-light list-unstyled p-3">
                <li class="mb-2 text-decoration-none"><strong>Salary: $</strong><? echo $listing->salary ?></li>
                <li class="mb-2 text-decoration-none">
                    <strong>Location: </strong><? echo $company->address ?>
                    <span class="badge bg-primary rounded-pill px-2 py-1 ml-2">Local</span>
                </li>
                <li class="mb-2 text-decoration-none">
                    <strong>Tags:</strong> <span><? echo $listing->tags ?></span>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="container mt-4 mb-2">
    <h3>Job Details</h3>
    <div class="rounded-lg shadow bg-white p-4">
        <h5 class="text-primary"> About the Company </h5>
        <p class="ms-4">Name: <? echo $company->title ?></p>
        <p class="ms-4">Description: <? echo $company->description ?></p>

        <h5 class="text-primary"> Job Requirements </h5>
        <p class="ms-4"> <? echo $listing->requirement ?> </p>

        <h5 class="text-primary">Benefits</h5>
        <p class="ms-4"> <? echo $listing->benefit ?> </p>
    </div>
    <p class="mt-4">
        Put "Job Application" as the subject of your email and attach your resume.
    </p>
    <a href="mailto:<? echo $company->email ?>?subject=Job Application" class="text-center btn btn-outline-primary rounded p-2 w-100">
        Apply Now
    </a>
</div>

<? Dialog::layouts('footer') ?>