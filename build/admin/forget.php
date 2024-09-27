<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION["user"])) {
   header("Location: login.php");
}

if (isset($_SESSION["user"]["username"]) &&
    ($_SESSION["user"]["role"])) {

    $username = $_SESSION["user"]["username"];
    $role = $_SESSION["user"]["role"];
}

if (isset($_POST["reset"])) {
    $currentPassword = $_POST["current_password"];
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        echo "All fields are required";
    } else {
        require_once "database.php";

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $_SESSION["user"]["username"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            if (password_verify($currentPassword, $user["password"])) {
                if ($newPassword === $confirmPassword) {
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
                    $updateStmt->bind_param("ss", $hashedPassword, $_SESSION["user"]["username"]);
                    $updateStmt->execute();
                    $success = "Password changed successfully!";
                } else {
                    $error = "New password and confirm password do not match.";
                }
            } else {
                $error = "Current password is incorrect.";
            }
        } else {
            $error = "User not found.";
        }
    }
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
    <title>User Dashboard</title>
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
            <a class="nav-link active" aria-current="page" href="">Change Password</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
        </li>
    </ul>
    <div id="password">
        <br>
        <?php if (isset($success)) : ?>
            <div class='alert alert-success'><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (isset($error)) : ?>
            <div class='alert alert-danger'><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="forget.php" method="POST">
            <div class="row g-3 align-items-center">
                <div class="row-auto">
                    <input type="password" placeholder="Enter Current Password" name="current_password" class="form-control" required>
                </div>
                <div class="row-auto">
                    <input type="password" placeholder="Enter New Password" name="new_password" class="form-control" required>
                </div>
                <div class="row-auto">
                    <input type="password" placeholder="Confirm Password" name="confirm_password" class="form-control" required>
                </div>
                <div class="row-btn">
                    <input type="submit" value="Change" name="reset" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>