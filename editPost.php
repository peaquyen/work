<?
require "inc/init.php";

$data = ['pageTitle' => 'Post Job'];

Dialog::layouts('header', $data);

$id = $_GET['id'];
$listing = new Listing();

$conn = require "inc/db.php";

$dataListing =  $listing::getById($conn, $id);

$company = new Company();
$dataCompany = Company::getById($conn, $dataListing->company_id);

if (!Auth::isLoggedIn()) {
    header("Location: index.php");
    exit();
}
?>

<section class="d-flex justify-content-center align-items-center bg-light">
    <div class="bg-white p-5 rounded shadow-sm col-md-5 mx-3">
        <h2 class="text-center text-uppercase">Update Job Listing</h2>
        <h3 class="text-center text-secondary">Job Info</h3>

        <form method="post" data-id-listing="<? echo $dataListing->id ?>" data-id-company="<? echo $dataCompany->id ?>">
            <div class="form-group mg-form">
                <label for="title-job">Title</label>
                <input type="text" name="title-job" id="title-job" class="form-control" placeholder="<? echo $dataListing->title ?>">
            </div>
            <div class="form-group mg-form">
                <label for="description-job">Description</label>
                <div>
                    <textarea id="description-job" name="description-job" placeholder="<?php echo $dataListing->description; ?>" class="form-control w-100 border rounded"></textarea>
                </div>
            </div>
            <div class="form-group mg-form">
                <label for="tags">Tags</label>
                <input type="text" name="tags" id="tags" class="form-control" placeholder="Ex: Java, Python<?php echo $dataListing->tags; ?>">
            </div>
            <div class="form-group mg-form">
                <label for="salary">Salary</label>
                <input type="text" name="salary" id="salary" class="form-control" placeholder="<?php echo $dataListing->salary; ?>">
            </div>
            <div class="form-group mg-form">
                <label for="requirements">Requirements</label>
                <input type="text" name="requirements" id="requirements" class="form-control" placeholder="<?php echo $dataListing->requirement; ?>">
            </div>
            <div class="form-group mg-form">
                <label for="benefits">Benefits</label>
                <input type="text" name="benefits" id="benefits" class="form-control" placeholder="<?php echo $dataListing->benefit; ?>">
            </div>
            <h3 class="text-center text-secondary mt-3">Company Info & Location</h3>
            <div class="form-group mg-form">
                <label for="title-company">Company</label>
                <input type="text" name="title-company" id="title-company" class="form-control" placeholder="<? echo $dataCompany->title; ?>">
            </div>
            <div class="form-group mg-form">
                <label for="address">Address</label>
                <input type="text" name="address" id="address" class="form-control" placeholder="<? echo $dataCompany->address; ?>">
            </div>
            <div class="form-group mg-form">
                <label for="description-company">Description</label>
                <input type="text" name="description-company" id="description-company" class="form-control" placeholder="<? echo $dataCompany->description; ?>">
            </div>
            <div class="form-group mg-form">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" placeholder="<? echo $dataCompany->phone; ?>">
            </div>
            <div class="form-group mg-form">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" class="form-control" placeholder="<? echo $dataCompany->email; ?>">
            </div>
            <button type="submit" class="btn-edit-submit mg-btn btn-submit btn btn-primary btn-block">Save</button>
            <a href="index.php" class="mg-btn btn btn-outline-danger btn-block">Cancel</a>
        </form>
    </div>
</section>

<? Dialog::layouts('footer') ?>