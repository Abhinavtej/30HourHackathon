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

if (isset($_SESSION["success_message"]) || isset($_SESSION['error_message'])) {
    $success = $_SESSION["success_message"];
    $error = $_SESSION['error_message'];
    unset($_SESSION["success_message"]);
    unset($_SESSION["error_message"]);
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
    <title>Student Co Data</title>
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
            <a class="nav-link active" aria-current="page" href="">Student Co Data</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="forget.php">Change Password</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
        </li>
    </ul>
    <div id="marks">
        <br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Sno</th>
                    <th scope="col">Name</th>
                    <th scope="col">Roll No</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Year</th>
                    <th scope="col">Branch</th>
                    <th scope="col">Section</th>
                    <th scope="col">Role</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once "database.php";

                $stmt = $conn->prepare("SELECT * FROM student_co");
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $sno = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $sno . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["rollno"] . "</td>";
                        echo "<td>" . $row["phone_number"] . "</td>";
                        echo "<td>" . $row["year"] . "</td>";
                        echo "<td>" . $row["branch"] . "</td>";
                        echo "<td>" . $row["section"] . "</td>";
                        echo "<td>" . $row["role"] . "</td>";
                        echo "</tr>";
                        $sno++;
                    }
                } else {
                    echo "<tr><td colspan='6'>No data found</td></tr>";
                }

                $stmt->close();
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>