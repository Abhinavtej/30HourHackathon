<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "Dean") {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION["success_message"]) || isset($_SESSION['error_message'])) {
    $success = $_SESSION["success_message"];
    $error = $_SESSION['error_message'];
    unset($_SESSION["success_message"]);
    unset($_SESSION["error_message"]);
}


if (isset($_SESSION["user"]["username"]) &&
    isset($_SESSION["user"]["role"])) {

    $username = $_SESSION["user"]["username"];
    $role = $_SESSION["user"]["role"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        @media screen and (max-width: 990px) {
            .buttons {
                display: block;
            }
            .buttons a {
                margin-bottom: 10px;
            }
        }
    </style>
    <title>Admin Dashboard</title>
</head>
<body>
<div class="container">
        <div class="logo">
            <img src="mru.png" id="mru" alt="Logo" width="8%" height="70" style="margin: 25px">
            <img src="Dept.png" id="dept" alt="Logo" width="40%" height="25" style="margin: 0 0 2vh 0">
        </div>
    <h2 style="text-align: center;">Welcome to <?php echo $role; ?> Dashboard</h2>
    <br>
    <ul class="nav nav-tabs justify-content-center">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="forget.php">Change Password</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
        </li>
    </ul>
    <div id="profile">
        <br>
        <?php if (isset($success)) : ?>
            <div class='alert alert-success'><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (isset($error)) : ?>
            <div class='alert alert-danger'><?php echo $error; ?></div>
        <?php endif; ?>
        <h4>Event Management</h4>
        <div class="buttons">
            <div class="form-btn">
                <a class="btn btn-primary" href="register.php">Registration Form</a>
            </div>
            <div class="form-btn">
                <a class="btn btn-primary" href="registration_data.php">Registration Data</a>
            </div>
            <div class="form-btn">
                <a href="studentco_data.php" class="btn btn-primary">Student Co Data</a>
            </div>
        </div>
    </div>
    <div class="footer">
        <p>Any queries -> <a href="contact.php">Contact us</a> </p>
    </div>
</div>
</body>
</html>