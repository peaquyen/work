<?php

require "../inc/init.php";

$db = require '../inc/db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['formData'])) {

    parse_str($data['formData'], $formData);

    if ($data['status'] == "add") {

        // get data listing from form
        $title_job = $formData['title-job'];
        $description_job = $formData['description-job'];
        $salary = ($formData['salary'] == '') ? 0 : $formData['salary'];
        $requirements = $formData['requirements'];
        $benefits = $formData['benefits'];
        $tags = $formData['tags'];

        // get data company from form
        $title_company = $formData['title-company'];
        $address = $formData['address'];
        $description_company = $formData['description-company'];
        $phone = $formData['phone'];
        $email = $formData['email'];

        //check whether the company already exists
        if (!Company::isExist($db, $title_company)) {
            $company = new Company($title_company, $description_company, $address, $phone, $email);
            $company->add($db);
        }

        $id_company = Company::getIdByTitle($db, $title_company);

        $listing = new Listing($title_job, $description_job, $salary, $tags, $requirements, $benefits, $id_company, $_SESSION['user_id']);
        $addResult = $listing->add($db);
        $id_listing = $listing::lastId($db);
    }

    if ($data['status'] == "update") {
        $id_listing = $data['idListing'];
        $id_company = $data['idCompany'];

        $company = new Company();
        $company = $company::getById($db, $id_company);

        // check if the company name is changed or not
        $title_company = $formData['title-company'] == '' ? $company->title : $formData['title-company'];
        $address = $formData['address'] == '' ? $company->address : $formData['address'];
        $description_company = $formData['description-company'] == '' ? $company->description : $formData['description-company'];
        $phone = $formData['phone'] == '' ? $company->phone : $formData['phone'];
        $email = $formData['email'] == '' ? $company->email : $formData['email'];

        // update company data
        $company = new Company($title_company, $description_company, $address, $phone, $email);
        $company->update($db, $id_company);


        $listing = new Listing();
        $listing = $listing::getById($db, $id_listing);

        // get data listing from form is changed or not
        $title_job = $formData['title-job'] == '' ? $listing->title : $formData['title-job'];
        $description_job = $formData['description-job'] == '' ? $listing->description : $formData['description-job'];
        $salary = ($formData['salary'] == '') ? $listing->salary : $formData['salary'];
        $requirements = $formData['requirements'] == '' ? $listing->requirement : $formData['requirements'];
        $benefits = $formData['benefits'] == '' ? $listing->benefit : $formData['benefits'];
        $tags = $formData['tags'] == '' ? $listing->tags : $formData['tags'];


        // update listing data
        $listing = new Listing($title_job, $description_job, $salary, $tags, $requirements, $benefits, $id_company, $_SESSION['user_id']);
        $addResult = $listing->update($db, $id_listing);
    }


    if ($addResult) {
        header('Content-Type: application/json');
        echo json_encode(["status" => "success", "message" => "Data saved successfully", "id" => $id_listing]);
        exit();
    } else {
        header('Content-Type: application/json');
        echo json_encode(["status" => "error", "message" => "Data failed"]);
    }
}
