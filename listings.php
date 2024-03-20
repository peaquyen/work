<?
require "inc/init.php";

Dialog::layouts('header');

$db = require 'inc/db.php';

if (!Auth::isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$limit = LISTINGS_PER_PAGE;
$currentPage = $_GET['page'] ?? 1;
$total = Listing::count($db);

$config = [
    'total' => $total,
    'limit' => $limit,
    'full' => false,
];

$listings = Listing::getPaging($db, $limit, ($currentPage - 1) * $limit);

$company = new Company();
?>

<div class="container mt-3">
    <h1 class="text-center border mb-1 p-3">All Jobs</h1>
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
    </div>
</div>

<nav aria-label="navigation" class="my-5">
    <?
    $page = new Pagination($config);
    echo $page->getPagination();
    ?>
</nav>


<? Dialog::layouts('footer') ?>