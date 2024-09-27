<?php
$error = "";
$success = "";

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION["user"]) || ($_SESSION["user"]["role"] !== "Admin")) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION["user"]["username"]) && isset($_SESSION["user"]["role"])) {
    $username = $_SESSION["user"]["username"];
    $role = $_SESSION["user"]["role"];
}

require_once "database.php";

$branch_query = "SELECT * FROM branch";
$branch_result = $conn->query($branch_query);

$year_query = "SELECT * FROM year";
$year_result = $conn->query($year_query);

$section_query = "SELECT * FROM section";
$section_result = $conn->query($section_query);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["rollno"])) {
    $rollno = $_POST["rollno"];
    $stmt = $conn->prepare("SELECT * FROM student_co WHERE rollno = ?");
    $stmt->bind_param("s", $rollno);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        $name = $student["name"];
        $phone_number = $student["phone_number"];
        $branch = $student["branch"];
        $year = $student["year"];
        $section = $student["section"];
    } else {
        $error = "Student not found";
    }

    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $name = $_POST["name"];
    $phone_number = $_POST["phone_number"];
    $branch = $_POST["branch"];
    $year = $_POST["year"];
    $section = $_POST["section"];
    $rollno = $_POST["rollno"];

    $stmt = $conn->prepare("UPDATE student_co SET name=?, phone_number=?, branch=?, year=?, section=? WHERE rollno=?");
    $stmt->bind_param("ssssss", $name, $phone_number, $branch, $year, $section, $rollno);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $success = "Student Co data updated successfully";
    } else {
        $error = "Failed to update student co data";
    }

    $stmt->close();
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Edit Student Data</title>
    <style>
        .container {
            overflow-y: auto;
            max-height: calc(100vh - 40px);
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
            <a class="nav-link active" aria-current="page" href="">Edit Student Co Data</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="forget.php">Change Password</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
        </li>
    </ul>
    <br>
    <?php if ($error) : ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if ($success) : ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    <?php if (!isset($name)) : ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <input type="text" placeholder="Enter Rollno" name="rollno" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <br>
    <?php endif; ?>
    <br>
    <?php if (isset($name)) : ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="rollno" value="<?php echo $rollno; ?>"> 
            <div class="form-group">
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" required>
            </div>
            <div class="form-group">
                <input type="text" name="phone_number" class="form-control" value="<?php echo $phone_number; ?>" required>
            </div>
            <!-- Branch Selection -->
            <div class="form-group">
                <select name="branch" id="branch" class="form-select">
                    <option selected disabled>Select Branch</option>
                    <?php while ($branch = $branch_result->fetch_assoc()) : ?>
                        <option value="<?php echo $branch['branch']; ?>" <?php if ($branch['branch'] == $student['branch']) echo "selected"; ?>><?php echo $branch['branch']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <!-- year Selection -->
            <div class="form-group">
                <select name="year" id="year" class="form-select">
                    <option selected disabled>Select year</option>
                    <?php while ($year = $year_result->fetch_assoc()) : ?>
                        <option value="<?php echo $year['year']; ?>" <?php if ($year['year'] == $student['year']) echo "selected"; ?>><?php echo $year['year']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <!-- Section Selection -->
            <div class="form-group">
                <select name="section" id="section" class="form-select">
                    <option selected disabled>Select Section</option>
                    <?php while ($section = $section_result->fetch_assoc()) : ?>
                        <option value="<?php echo $section['section']; ?>" <?php if ($section['section'] == $student['section']) echo "selected"; ?>><?php echo $section['section']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Update Data</button>
        </form>
    <?php endif; ?>
</div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
