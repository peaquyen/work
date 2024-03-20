<?
require "inc/init.php";
require "inc/header.php";
$db = require 'inc/db.php';

$listing = new Listing();
$listings = Listing::getPaging($db, 6, 0);

$company = new Company();
?>

<div class="container mx-auto p-2 mt-3">
    <h1 class="text-center border mb-1 p-3">Recent Jobs</h1>
    <div class="row">
        <? foreach ($listings as $l) : ?>
            <? $company = Company::getById($db, $l->company_id); ?>
            <div class="col-12 col-md-4 g-4">
                <div class="rounded-lg shadow bg-white p-4">
                    <div>
                        <h4><? echo $l->title ?></h4>
                        <p class="text-muted mt-2 hidden-text"><? echo $l->description ?></p>
                        <ul class="bg-light list-unstyled rounded p-3">
                            <li class="mb-2 text-decoration-none"><strong>Salary: $</strong><? echo $l->salary ?></li>
                            <li class="mb-2 text-decoration-none">
                                <strong>Location:</strong> <? echo $company->address ?>
                                <span class="badge bg-primary rounded-pill px-2 py-1 ml-2">Local</span>
                            </li>
                            <li class="mb-2 text-decoration-none">
                                <strong>Tags:</strong> <span><? echo $l->tags ?></span>
                            </li>
                        </ul>
                        <a href="details.php?id=<? echo $l->id ?>" class="btn btn-outline-primary btn-block w-100">
                            Details
                        </a>
                    </div>
                </div>
            </div>
        <? endforeach; ?>
        <a href="listings.php" class="mt-4 fs-5 text-index text-center text-decoration-none">
            <i class="fa fa-arrow-alt-circle-right"></i>
            Show All Jobs
        </a>
    </div>
</div>

<? require "inc/footer.php" ?>