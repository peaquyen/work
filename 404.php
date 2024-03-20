<?
$error = $_GET['error'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Jobs</title>
</head>

<body>
    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="text-center row">
            <div class="col-md-6">
                <img src="images/error.jpg" class="img-fluid">
            </div>
            <div class="col-md-6 mt-5">
                <p class="fs-3">
                    <span class="text-danger">Oops!</span>
                    Have problems!
                </p>
                <p class="lead">
                    <? echo $error ?>
                </p>
                <a href="index.php" class="btn btn-primary">Home</a>
            </div>
        </div>
    </div>
</body>

</html>