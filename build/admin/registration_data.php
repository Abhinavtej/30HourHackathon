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
    <title>Registration Data</title>
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
    <h2 style="text-align: center;">Welcome to <?php echo $role; ?> Dashboard</h2>
    <br>
    <ul class="nav nav-tabs justify-content-center">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="">Registration Data</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="forget.php">Change Password</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
        </li>
    </ul>
    <button class="btn btn-primary" onclick="printTable()">Print Data</button>
    <button class="btn btn-primary" onclick="downloadTableAsXLSX()">Download .XLSX File</button>
    <div id="marks">
        <br>
        <table class="table table-secondary" id="dataTable">
            <thead>
                <tr>
                    <th scope="col">Sno</th>
                    <th scope="col">Team Id</th>
                    <th scope="col">Team Name</th>
                    <th scope="col">Team Size</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Roll Number</th>
                    <th scope="col">Year</th>
                    <th scope="col">College/University</th>
                    <th scope="col">State</th>
                    <th scope="col">Food</th>
                    <th scope="col">Tshirt Size</th>
                    <th scope="col">Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once "database.php";

                $stmt = $conn->prepare("SELECT *
                    FROM participant p
                    JOIN team t ON t.teamid = p.teamid
                    JOIN payment s ON s.teamid = p.teamid
                    ");
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $rows = []; // Store all rows in an array
                    
                    // Fetch all rows first
                    while ($row = $result->fetch_assoc()) {
                        $rows[] = $row;
                    }
                
                    $sno = 1; // Start serial number
                    $totalRows = count($rows);
                
                    // Output rows with rowspan handling
                    $i = 0;
                    while ($i < $totalRows) {
                        $teamId = $rows[$i]["teamid"];
                        $teamName = $rows[$i]["teamname"];
                        $teamSize = $rows[$i]["teamsize"]; // Dynamically set rowspan based on actual team size
                        
                        // Apply border if needed for grouping
                        $borderClass = ($i > 0) ? 'border-top: 1.5px solid #000;' : '';
                
                        // Output the main team row with rowspan
                        echo "<tr style='$borderClass'>";
                        echo "<td rowspan='$teamSize'>" . $sno . "</td>";
                        echo "<td rowspan='$teamSize'>" . $teamId . "</td>";
                        echo "<td rowspan='$teamSize'>" . $teamName . "</td>";
                        echo "<td rowspan='$teamSize'>" . $rows[$i]["teamsize"] . "</td>";
                        echo "<td>" . $rows[$i]["name"] . "</td>";
                        echo "<td>" . $rows[$i]["email"] . "</td>";
                        echo "<td>" . $rows[$i]["phone_number"] . "</td>";
                        echo "<td>" . $rows[$i]["rollno"] . "</td>";
                        echo "<td>" . $rows[$i]["year"] . "</td>";
                        echo "<td>" . $rows[$i]["college"] . "</td>";
                        echo "<td>" . $rows[$i]["state"] . "</td>";
                        echo "<td>" . $rows[$i]["food"] . "</td>";
                        echo "<td>" . $rows[$i]["tshirt"] . "</td>";
                        echo "<td rowspan='$teamSize'>" . $rows[$i]["payment_status"] . "</td>";
                        echo "</tr>";
                
                        // Output the remaining rows for the team
                        for ($j = 1; $j < $teamSize; $j++) {
                            $i++; // Increment to the next row of the same team
                            if (isset($rows[$i])) {
                                echo "<tr>";
                                echo "<td>" . $rows[$i]["name"] . "</td>";
                                echo "<td>" . $rows[$i]["email"] . "</td>";
                                echo "<td>" . $rows[$i]["phone_number"] . "</td>";
                                echo "<td>" . $rows[$i]["rollno"] . "</td>";
                                echo "<td>" . $rows[$i]["year"] . "</td>";
                                echo "<td>" . $rows[$i]["college"] . "</td>";
                                echo "<td>" . $rows[$i]["state"] . "</td>";
                                echo "<td>" . $rows[$i]["food"] . "</td>";
                                echo "<td>" . $rows[$i]["tshirt"] . "</td>";
                                echo "</tr>";
                            }
                        }
                
                        // Increment serial number and move to the next team
                        $sno++;
                        $i++; // Move to the next team's first row
                    }
                } else {
                    echo "<tr><td colspan='14'>No data found</td></tr>";
                }
                

                $stmt->close();
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    function printTable() {
        var printWindow = window.open('', '', 'height=600,width=800');
        var tableElement = document.getElementById("marks").outerHTML;
        var styles = `
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
            <style>
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
                /* Add any other custom styles you need */
            </style>
        `;

        printWindow.document.write('<html><head><title>Print Table</title>');
        printWindow.document.write(styles);  // Write styles to the new window
        printWindow.document.write('</head><body>');
        printWindow.document.write(tableElement);  // Write the table to the new window
        printWindow.document.write('</body></html>');

        printWindow.document.close();  // Close the document to finish writing
        printWindow.focus();  // Focus on the new window
    }
</script>
<script>
    function downloadTableAsXLSX() {
        var tableElement = document.getElementById("marks");

        // Convert the table to a worksheet
        var workbook = XLSX.utils.table_to_book(tableElement, {sheet: "Sheet 1"});

        // Create the Excel file and trigger the download
        XLSX.writeFile(workbook, 'registration_data.xlsx');
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>