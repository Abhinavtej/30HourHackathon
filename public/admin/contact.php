<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "Admin" && $_SESSION["user"]["role"] !== "Dean") {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION["user"]["username"]) && isset($_SESSION["user"]["role"])) {
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
    <title>Contact us</title>
    <style>
        .container {
            overflow-y: auto;
            max-height: calc(100vh - 40px);
        }
        .form-control, .form-select {
            width: 50%;
        }
    </style>
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
            <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="">Contact us</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="forget.php">Change Password</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
        </li>
    </ul>
    <div id="register">
        <br>
        <form action="https://api.web3forms.com/submit" method="post">
            <input type="hidden" name="access_key" value="14b7c9da-a526-4cdf-ad80-437f89353e2f">
            <div class="form-group">
                <input type="hidden" value="<?php echo $username ?>" name="roll" class="form-control">
            </div>
            <div class="form-group">
                <input type="text" placeholder="Enter Name" name="Name" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="email" placeholder="Enter Email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <textarea name="message" placeholder="Enter Message" id="" cols="40" rows="5" class="form-control" required></textarea>
            </div>
            <div class="form-btn">
                <input type="submit" value="Submit" class="btn btn-primary">
            </div>
        </form>
    </div>
    <br><br>
    <p><span>Mail us at - -> </span><a href="mailto:nispmruh@mallareddyuniversity.ac.in">admin</a></p>
</div>
</body>
</html>