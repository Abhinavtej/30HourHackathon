<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION["user"]) || ($_SESSION["user"]["role"] !== "Admin" && $_SESSION["user"]["role"] !== "Dean")) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["user"]["username"] ?? '';
$role = $_SESSION["user"]["role"] ?? '';

$success = $_SESSION["success_message"] ?? '';
$error = $_SESSION["error_message"] ?? '';
unset($_SESSION["success_message"], $_SESSION["error_message"]);

require_once "database.php";

if (isset($_POST["register"])) {
    $teamid = $_POST['team-id'] ?? '';

    if ($teamid) {
        $updateStmt = $conn->prepare("UPDATE payment SET payment_status = 'Verified' WHERE teamid = ?");
        $updateStmt->bind_param("s", $teamid);
        
        if ($updateStmt->execute()) {
            $_SESSION["success_message"] = "Payment status updated successfully.";
        } else {
            $_SESSION["error_message"] = "Error updating payment status.";
        }

        $updateStmt->close();
    }
}

$teamid_query = "SELECT * FROM payment WHERE payment_status = 'Not Verified'";
$teamid_result = $conn->query($teamid_query);
if (!$teamid_result) {
    die("Error fetching data: " . $conn->error);
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
    <title>Verify Payments</title>
    <style>
        td {
            height: 3em;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .border-top {
            border-top: 2px solid #000;
        }
        .btn {
            margin: 20px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="logo">
        <img src="mru.png" id="mru" alt="Logo" width="8%" height="70" style="margin: 25px">
        <img src="Dept.png" id="dept" alt="Logo" width="40%" height="25" style="margin: 0 0 2vh 0">
    </div>
    <h2 style="text-align: center;">Welcome to <?php echo htmlspecialchars($role, ENT_QUOTES, 'UTF-8'); ?> Dashboard</h2>
    <br>
    <ul class="nav nav-tabs justify-content-center">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="">Verify Payments</a>
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
        <table class="table table-secondary" id="dataTable">
            <thead>
                <tr>
                    <th scope="col">Sno</th>
                    <th scope="col">Team Id</th>
                    <th scope="col">Team Name</th>
                    <th scope="col">Team Size</th>
                    <th scope="col">Transaction Id</th>
                    <th scope="col">Payment Screenshot</th>
                    <th scope="col">Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->prepare("SELECT *
                    FROM team t
                    JOIN payment p ON t.teamid = p.teamid
                    WHERE p.payment_status = 'Not Verified'
                    ");
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $sno = 1;
                    while ($row = $result->fetch_assoc()) {
                        $teamId = htmlspecialchars($row["teamid"], ENT_QUOTES, 'UTF-8');
                        $teamName = htmlspecialchars($row["teamname"], ENT_QUOTES, 'UTF-8');
                        $teamSize = htmlspecialchars($row["teamsize"], ENT_QUOTES, 'UTF-8');
                        $transactionId = htmlspecialchars($row["transaction_id"], ENT_QUOTES, 'UTF-8');
                        $paymentStatus = htmlspecialchars($row["payment_status"], ENT_QUOTES, 'UTF-8');

                        echo "<tr>";
                        echo "<td>" . $sno . "</td>";
                        echo "<td>" . $teamId . "</td>";
                        echo "<td>" . $teamName . "</td>";
                        echo "<td>" . $teamSize . "</td>";
                        echo "<td>" . $transactionId . "</td>";
                        echo "<td><a href=\"pss.php?teamid=" . urlencode($teamId) . "\" target=\"_blank\">View</a></td>";
                        echo "<td>" . $paymentStatus . "</td>";
                        echo "</tr>";

                        $sno++;
                    }
                } else {
                    echo "<tr><td colspan='7'>No data found</td></tr>";
                }

                $stmt->close();
                ?>
            </tbody>
        </table>
        <br>
        <h4>Verify the Payment</h4>
        <br>
        <form action="verify_payment.php" method="post">
            <div class="form-group">
                <label for="team-id">Team Id</label>
                <select name="team-id" id="team-id" class="form-select" required>
                    <option value="" selected disabled>Select</option>
                    <?php while($team_id = $teamid_result->fetch_assoc()) : ?>
                        <option value="<?php echo htmlspecialchars($team_id['teamid'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($team_id['teamid'], ENT_QUOTES, 'UTF-8'); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-btn">
                <input type="submit" value="Verify" name="register" class="btn btn-primary">
            </div>
        </form>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
