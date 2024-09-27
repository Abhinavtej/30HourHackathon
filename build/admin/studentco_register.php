<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "Admin") {
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

if (isset($_POST["register"])) {
    $rollno = strtoupper($_POST["rollno"]);

    $stmt = $conn->prepare("SELECT * FROM student_co WHERE rollno = ?");
    $stmt->bind_param("s", $rollno);
    $stmt->execute();
    $result = $stmt->get_result();
        
    if ($result->num_rows > 0) {
        $error = "User already exists";
        $stmt->close();
    } else {
        $rollno = strtoupper($_POST["rollno"]);
        $name = strtoupper($_POST["name"]);
        $phone_number = $_POST["phone_number"];
        $year = $_POST["year"];
        $section = $_POST["section"];
        $branch = $_POST["branch"];

        $insertStudentStmt = $conn->prepare("INSERT INTO student_co (rollno, name, phone_number, branch, year, section) VALUES (?, ?, ?, ?, ?, ?)");
        $insertStudentStmt->bind_param("ssssss", $rollno, $name, $phone_number, $branch, $year, $section);
        $insertStudentStmt->execute();
        $insertStudentStmt->close();

        $success = "User registered successfully";
    }
    $conn->close();
}

if (isset($_POST['submit']) && isset($_FILES['file'])) {
    $csvFile = $_FILES['file']['tmp_name'];

    $file = fopen($csvFile, 'r');

    fgetcsv($file);

    while (($row = fgetcsv($file)) !== false) {
        $rollno = strtoupper($row[0]);
        $name = strtoupper($row[1]);
        $phone_number = $row[2];
        $year = $row[3];
        $section = $row[4];
        $branch = $row[5];

        // Check if the username already exists
        $stmt = $conn->prepare("SELECT * FROM student_co WHERE rollno = ?");
        $stmt->bind_param("s", $rollno);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            if (empty($error)) {
                $error = "";
            }
            $error .= "User with username $rollno already exists. Skipped insertion.<br>";
            $stmt->close();
        } else {
            $stmt->close();

            $insertStudentStmt = $conn->prepare("INSERT INTO student_co (rollno, name, phone_number, branch, year, section) VALUES (?, ?, ?, ?, ?, ?)");
            $insertStudentStmt->bind_param("ssssss", $rollno, $name, $phone_number, $branch, $year, $section);
            $insert_success = $insertStudentStmt->execute();
            $insertStudentStmt->close();

            if ($sql_success && $insert_success) {
                if (empty($success)) {
                    $success = "";
                }
                $success .= "Record for $rollno inserted successfully.<br>";
            } else {
                $error .= "Error inserting record for $rollno: " . $conn->error . "<br>";
            }
        }
    }

    fclose($file);
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
    <title>Student Registration</title>
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
            <a class="nav-link active" aria-current="page" href="">Register Student Co</a>
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
        <?php if (isset($success)) : ?>
            <div class='alert alert-success'><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (isset($error)) : ?>
            <div class='alert alert-danger'><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="studentco_register.php" method="post">
            <div class="form-group">
                <input type="text" placeholder="Enter Roll No" name="rollno" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="text" placeholder="Enter Name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="number" placeholder="Enter Phone Number" name="phone_number" class="form-control" required>
            </div>
            <!-- Branch Selection -->
            <div class="form-group">
                <select name="branch" id="branch" class="form-select" required>
                    <option value="" selected disabled>Select Branch</option>
                    <?php while ($branch = $branch_result->fetch_assoc()) : ?>
                        <option value="<?php echo $branch['branch']; ?>"><?php echo $branch['branch']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <!-- year Selection -->
            <div class="form-group">
                <select name="year" id="year" class="form-select" required>
                    <option value="" selected disabled>Select year</option>
                    <?php while ($year = $year_result->fetch_assoc()) : ?>
                        <option value="<?php echo $year['year']; ?>"><?php echo $year['year']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <!-- Section Selection -->
            <div class="form-group">
                <select name="section" id="section" class="form-select" required>
                    <option value="" selected disabled>Select Section</option>
                    <?php while ($section = $section_result->fetch_assoc()) : ?>
                        <option value="<?php echo $section['section']; ?>"><?php echo $section['section']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-btn">
                <input type="submit" value="Register" name="register" class="btn btn-primary">
            </div>
        </form>
    </div>
    <br><br>
    <h4>Upload CSV File</h4>
    <br>
    <p>File Format - <strong>.csv</strong><br>
        Column Order - 
        <ul>
            <li>Roll No (ex: 2211CS020***)</li>
            <li>name</li>
            <li>phone_number</li>
            <li>year (ex: III)</li>
            <li>section (ex: Alpha, Beta)</li>
            <li>branch (ex: AIML)</li>
        </ul>
    </p> <br>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
    <input type="file" name="file" accept=".csv" class="form-control" required>
    </div>
    <div class="form-btn">
    <button type="submit" name="submit" class="btn btn-primary">Upload</button>
    </div>
    </form>
</div>
</body>
</html>