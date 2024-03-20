<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><? echo !empty($data['pageTitle']) ? $data['pageTitle'] : 'Jobs'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css?ver=<? echo rand(); ?>">
</head>

<body>
    <div class="bg-primary p-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="font-weight-bold">
                <a href="index.php" class="text-white text-decoration-none">Jobs</a>
            </h1>
            <div class="col-md-5 text-end">
                <? if (!Auth::isLoggedIn()) : ?>
                    <a href="login.php" class="btn fs-5 me-2 text">Login</a>
                    <a href="register.php" class="btn fs-5 text">Sign-up</a>
                <? else : ?>
                    <? if (isset($_SESSION['admin']) && isset($_SESSION['user_id']) ) : ?>
                        <a href="manageUsers.php" class="btn fs-5 text me-2">Manage Users</a>
                    <? endif; ?>
                    <? if (isset($_SESSION['user_id']) && !isset($_SESSION['admin'])) : ?>
                        <a href="managePosts.php" class="btn fs-5 text me-2">Manage Posts</a>
                        <a href="post-job.php" class="btn fs-5 text">
                            <i class="fa fa-edit"></i> Post a Job
                        </a>
                    <? endif; ?>
                    <a href="logout.php" class="btn fs-5 text">Logout</a>
                <? endif; ?>
            </div>
        </div>
    </div>
    <div class="promotions d-flex align-items-center">
        <div class="overlay"></div>
        <div class="summary text-white mx-auto text-center">
            <h1 class="title">Unlock Your Career Potential</h1>
            <p class="desc">Discover the perfect job opportunity for you.</p>
        </div>
    </div>
</body>

</html>