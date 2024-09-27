<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (isset($_SESSION["success_message"]) || isset($_SESSION['error_message'])) {
    $success = $_SESSION["success_message"];
    $error = $_SESSION['error_message'];
    unset($_SESSION["success_message"]);
    unset($_SESSION["error_message"]);
}

require_once "database.php";

function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

$teamId_query = "SELECT teamid FROM team ORDER BY teamid DESC LIMIT 1";
$teamId_execute = $conn->query($teamId_query);
$teamId_result = $teamId_execute->fetch_assoc();

if ($teamId_result) {
    $last_teamid = $teamId_result['teamid'];
    $prefix = substr($last_teamid, 0, 3);
    $last_number = intval(substr($last_teamid, 3));
    $new_number = str_pad($last_number + 1, 3, '0', STR_PAD_LEFT);
    $teamId = $prefix . $new_number;
} else {
    $teamId = 'MRU001';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Team Info
    $team_name = strtoupper(sanitizeInput($_POST["team-name"]));
    $team_size = filter_input(INPUT_POST, 'teamSize', FILTER_VALIDATE_INT);
    
    $yearMapping = [
        1 => '1st Year',
        2 => '2nd Year',
        3 => '3rd Year',
        4 => '4th Year',
    ];

    $lead_year = $_POST["lead-year"];
    $lead_year = isset($yearMapping[$lead_year]) ? $yearMapping[$lead_year] : '';

    if (isset($_FILES['team_file']) && $_FILES['team_file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['team_file']['tmp_name'];
        $team_file = file_get_contents($fileTmpPath);
    } else {
        $error = isset($_FILES['team_file']['error']) ? "Error uploading file: " . $_FILES['team_file']['error'] : "No file uploaded.";
    }

    $college = strtoupper($_POST['lead-college']);
    if ($college === 'OTHER') {
        $college = strtoupper(sanitizeInput($_POST['other-college']));
    }

    $members = [];
    $members[] = [
        'name' => strtoupper(sanitizeInput($_POST["lead-name"])),
        'email' => strtolower(sanitizeInput($_POST["lead-email"])),
        'phone' => sanitizeInput($_POST["lead-phone"]),
        'college' => strtoupper($college),
        'state' => strtoupper(sanitizeInput($_POST["lead-state"])),
        'rollno' => strtoupper(sanitizeInput($_POST["lead-rollno"])),
        'year' => strtoupper($lead_year),
        'food' => strtoupper(sanitizeInput($_POST["lead-food"])),
        'tshirt' => strtoupper(sanitizeInput($_POST["lead-tsize"])),
    ];

    for ($i = 1; $i < $team_size; $i++) {
        $member_year = isset($yearMapping[sanitizeInput($_POST["member{$i}-year"])]) ? $yearMapping[sanitizeInput($_POST["member{$i}-year"])] : '';

        $member_college = strtoupper(sanitizeInput($_POST["member{$i}-college"]));
        if ($member_college === 'OTHER') {
            $member_college = strtoupper(sanitizeInput($_POST["member{$i}-other-college"]));
        }

        $members[] = [
            'name' => strtoupper(sanitizeInput($_POST["member{$i}-name"])),
            'email' => strtolower(sanitizeInput($_POST["member{$i}-email"])),
            'phone' => sanitizeInput($_POST["member{$i}-phone"]),
            'college' => $member_college,
            'state' => strtoupper(sanitizeInput($_POST["member{$i}-state"])),
            'rollno' => strtoupper(sanitizeInput($_POST["member{$i}-roll"])),
            'year' => strtoupper($member_year),
            'food' => strtoupper(sanitizeInput($_POST["member{$i}-food"])),
            'tshirt' => strtoupper(sanitizeInput($_POST["member{$i}-tsize"])),
        ];
    }

    $transaction_id = sanitizeInput($_POST["transaction-id"]);
    $stmt = $conn->prepare("SELECT * FROM team WHERE teamname = ?");
    $stmt->bind_param("s", $team_name);
    $stmt->execute();
    $result = $stmt->get_result();
        
    if ($result->num_rows > 0) {
        $error = "Team Name already exists";
        $stmt->close();
    } else {
        $insertUserStmt = $conn->prepare("INSERT INTO team (teamid, teamname, teamsize) VALUES (?, ?, ?)");
        $insertUserStmt->bind_param("sss", $teamId, $team_name, $team_size);
        if (!$insertUserStmt->execute()) {
            $error = "Error inserting team: " . $insertUserStmt->error;
        }
        $insertUserStmt->close();

        $insertStudentStmt = $conn->prepare("INSERT INTO participant (teamid, name, email, phone_number, rollno, year, college, state, food, tshirt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($members as $member) {
            $insertStudentStmt->bind_param("ssssssssss", $teamId, $member['name'], $member['email'], $member['phone'], $member['rollno'], $member['year'], $member['college'], $member['state'], $member['food'], $member['tshirt']);
            if (!$insertStudentStmt->execute()) {
                $error = "Error inserting participant: " . $insertStudentStmt->error;
                break;
            }
        }
        $insertStudentStmt->close();

        $insertUserStmt = $conn->prepare("INSERT INTO payment (teamid, transaction_id, files) VALUES (?, ?, ?)");
        $insertUserStmt->bind_param("sss", $teamId, $transaction_id, $team_file);
        if (!$insertUserStmt->execute()) {
            $error = "Error inserting payment: " . $insertUserStmt->error;
        }
        $insertUserStmt->close();

        if (!isset($error)) {
            $success = "Team registered successfully";
        }
    }
    $conn->close();
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        #teamSize {
            width: 5em;
            text-align: center;
            border: 1px solid;
        }
        @media screen and (max-width: 990px) {
            .buttons {
                display: block;
            }
            .buttons a {
                margin-bottom: 10px;
            }
        }
    </style>
    <title>Registration Form</title>
</head>
<body>
<div class="container">
    <div class="logo">
        <img src="Dept.png" id="dept" alt="Logo" width="40%" height="25" style="margin: 0 0 2vh 0">
    </div>
    <h2 style="text-align: center;">Registration Form</h2>
    <hr>
    <div id="profile">
        <br>
        <?php if (isset($success)) : ?>
            <div class='alert alert-success'><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (isset($error)) : ?>
            <div class='alert alert-danger'><?php echo $error; ?></div>
        <?php endif; ?>
        <div id="register">
            <h4>Team Info</h4>
            <br>
            <form id="registrationForm" action="register.php" enctype="multipart/form-data" method="POST">
                <input type="text" id="team-id" value="<?php echo htmlspecialchars($teamId); ?>" hidden disabled>
                <div class="form-group">
                    <label for="team-name">Team Name</label>
                    <input type="text" placeholder="" name="team-name" id="team-name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="teamSize">Team Size</label>
                    <div class="input-group">
                        <button type="button" class="btn btn-outline-secondary" id="decrease">-</button>
                        <input type="number" id="teamSize" name="teamSize" value="1" min="1" max="4" readonly>
                        <button type="button" class="btn btn-outline-secondary" id="increase">+</button>
                    </div>
                </div>
                <br>
                <h4>Team Lead Info</h4> <br>
                <div class="form-group">
                    <label for="lead-name">Name</label>
                    <input type="text" placeholder="" name="lead-name" id="lead-name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="lead-email">Email</label>
                    <input type="email" name="lead-email" id="lead-email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="lead-phone">Contact Number</label>
                    <input type="text" id="lead-phone" name="lead-phone" class="form-control" required onkeypress="return isNumber(event)" minlength="10" maxlength="10">
                </div>
                <div class="form-group">
                    <label for="lead-college">College/University</label> 
                    <div style="border: 1px solid #ced4da; padding: 10px; border-radius: 5px; width: 15em">
                        <input type="radio" name="lead-college" id="lead-college" value="Malla Reddy University" onclick="toggleOtherCollege(false)">
                        <label for="mru">Malla Reddy University</label> &nbsp;&nbsp;
                        <input type="radio" id="other" name="lead-college" value="other" onclick="toggleOtherCollege(true)">
                        <label for="other">Other</label>
                    </div>
                    <div id="otherCollegeDiv" style="display: none; margin-top: 10px;">
                        <input type="text" id="otherCollege" name="other-college" placeholder="Enter College/University name" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="state">State/Union Territory</label>
                    <input type="text" id="state-search" value="" name="lead-state" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="lead-roll">Roll Number</label>
                    <input type="text" id="lead-roll" placeholder="" name="lead-rollno" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="year">Academic Year</label>
                    <select id="year" name="lead-year" class="form-select" required>
                        <option value="" disabled selected>Select Year</option>
                        <!-- Options will be added by JavaScript -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="lead-food">Food Preference</label> 
                    <div style="border: 1px solid #ced4da; padding: 10px; border-radius: 5px; width: 12em">
                        <input type="radio" id="lead-food" name="lead-food" value="Veg">
                        <label for="veg">Veg</label> &nbsp;&nbsp;
                        <input type="radio" id="lead-food" name="lead-food" value="Non Veg">
                        <label for="nonveg">Non Veg</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lead-tsize">Tshirt Size</label> 
                    <div style="border: 1px solid #ced4da; padding: 10px; border-radius: 5px; width: 18em">
                        <input type="radio" id="lead-tsize" name="lead-tsize" value="S">
                        <label for="tsize">S</label> &nbsp;&nbsp;
                        <input type="radio" id="lead-tsize" name="lead-tsize" value="M">
                        <label for="tsize">M</label> &nbsp;&nbsp;
                        <input type="radio" id="lead-tsize" name="lead-tsize" value="L">
                        <label for="tsize">L</label> &nbsp;&nbsp;
                        <input type="radio" id="lead-tsize" name="lead-tsize" value="XL">
                        <label for="tsize">XL</label> &nbsp;&nbsp;
                        <input type="radio" id="lead-tsize" name="lead-tsize" value="XXL">
                        <label for="tsize">XXL</label> &nbsp;&nbsp;
                    </div>
                </div>
                <div id="teamMembers">
                    <!-- Team member fields will be inserted here -->
                </div>
                <h4>Payment Info</h4> <br>
                <div class="form-group">
                    <label for="team-file">Payment QR ( Team Size - <span id="team-size-display">1</span> )</label>
                    <div style="border: 1px solid #ced4da; padding: 10px; border-radius: 5px; width: 18%; margin-top: 10px;">
                        <img id="payment-qr" src="teamsize_1.png" alt="Payment QR">
                    </div>
                </div>
                <div class="form-group">
                    <label for="team-file">Upload Payment Screenshot</label>
                    <input type="file" name="team_file" id="team-file" accept=".jpeg, .heic, .png, .pdf" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="transaction_id">Payment Transaction Id</label>
                    <input type="text" placeholder="" name="transaction-id" class="form-control" required>
                </div>
                <div class="form-btn">
                    <input type="submit" id="register-button" value="Register" name="register" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
    <br>
    <div class="footer">
        <p>Any queries -> <a href="contact.php">Contact us</a> </p>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const yearDropdown = document.getElementById('year');
    const years = ['1st Year', '2nd Year', '3rd Year', '4th Year'];
    const maxTeamSize = 4;
    const decreaseBtn = document.getElementById('decrease');
    const increaseBtn = document.getElementById('increase');
    const teamSizeInput = document.getElementById('teamSize');
    const teamMembersDiv = document.getElementById('teamMembers');

    years.forEach((year, index) => {
            let option = document.createElement('option');
            option.value = index + 1; // Value is 1, 2, 3, 4 corresponding to the year
            option.textContent = year;
            yearDropdown.appendChild(option);
    });

    function toggleOtherCollege(show) {
        document.getElementById('otherCollegeDiv').style.display = show ? 'block' : 'none';
        if (!show) {
            document.getElementById('otherCollege').value = '';
        }
    }

    function toggleOtherCollegeM(index, show) {
        document.getElementById(`otherCollegeDiv${index}`).style.display = show ? 'block' : 'none';
        if (!show) {
            document.getElementById(`member${index}-other-college`).value = '';
        }
    }

    function isNumber(event) {
        var charCode = (event.which) ? event.which : event.keyCode;
        // Allow only numbers (0-9)
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function updateTeamMembers() {
        const teamSize = parseInt(teamSizeInput.value);
        teamMembersDiv.innerHTML = '';
        document.getElementById('team-size-display').innerText = '1';

        for (let i = 2; i <= teamSize; i++) {
            const memberDiv = document.createElement('div');
            document.getElementById('team-size-display').innerText = teamSize;
            const stateSearchId = `state-search-${i-1}`;
            const qrImage = document.getElementById('payment-qr');
            if (teamSize === '1') {
                qrImage.src = 'teamsize_1.png';
            } else {
                qrImage.src = `teamsize_${teamSize}.png`;
            }

            memberDiv.innerHTML = `
                <h4>Team Member ${i-1} Info</h4><br>
                <div class="form-group">
                    <label for="member${i-1}-name">Name</label>
                    <input type="text" name="member${i-1}-name" id="member${i-1}-name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="member${i-1}-email">Email</label>
                    <input type="email" name="member${i-1}-email" id="member${i-1}-email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="member${i-1}-phone">Contact Number</label>
                    <input type="text" name="member${i-1}-phone" id="member${i-1}-phone" class="form-control" required onkeypress="return isNumber(event)" minlength="10" maxlength="10">
                </div>

                <div class="form-group">
                    <label for="member${i-1}-college">College</label> 
                    <div style="border: 1px solid #ced4da; padding: 10px; border-radius: 5px; width: 15em">
                        <input type="radio" name="member${i-1}-college" id="member${i-1}-college" value="Malla Reddy University" onclick="toggleOtherCollegeM(${i-1}, false)">
                        <label for="member${i-1}-mru">Malla Reddy University</label> &nbsp;&nbsp;
                        <input type="radio" name="member${i-1}-college" id="member${i-1}-college" value="other" onclick="toggleOtherCollegeM(${i-1}, true)">
                        <label for="member${i-1}-other">Other</label>
                    </div>
                    <div id="otherCollegeDiv${i-1}" style="display: none; margin-top: 10px;">
                        <input type="text" id="member${i-1}-other-college" name="member${i-1}-other-college" placeholder="Enter College/University Name" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="member${i-1}-state">State/Union Territory</label>
                    <input type="text" id="${stateSearchId}" name="member${i-1}-state" class="form-control" />
                </div>

                <div class="form-group">
                    <label for="member${i-1}-roll">Roll Number</label>
                    <input type="text" id="member${i-1}-roll" name="member${i-1}-roll" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="member${i-1}-year">Academic Year</label>
                        <select name="member${i-1}-year" class="form-select" required>
                            <option value="" disabled selected>Select Year</option>
                        </select>
                </div>

                <div class="form-group">
                    <label for="member${i-1}-food">Food Preference</label> 
                        <div style="border: 1px solid #ced4da; padding: 10px; border-radius: 5px; width: 12em">
                            <input type="radio" id="member${i-1}-food" name="member${i-1}-food" value="Veg">
                            <label for="member${i-1}-food">Veg</label> &nbsp;&nbsp;
                            <input type="radio" id="member${i-1}-food" name="member${i-1}-food" value="Non Veg">
                            <label for="member${i-1}-food">Non Veg</label>
                        </div>
                </div>

                <div class="form-group">
                    <label for="member${i-1}-tsize">Tshirst Size</label> 
                        <div style="border: 1px solid #ced4da; padding: 10px; border-radius: 5px; width: 18em">
                            <input type="radio" id="member${i-1}-tsize" name="member${i-1}-tsize" value="S">
                            <label for="member${i-1}-tsize">S</label> &nbsp;&nbsp;
                            <input type="radio" id="member${i-1}-tsize" name="member${i-1}-tsize" value="M">
                            <label for="member${i-1}-tsize">M</label> &nbsp;&nbsp;
                            <input type="radio" id="member${i-1}-tsize" name="member${i-1}-tsize" value="L">
                            <label for="member${i-1}-tsize">L</label> &nbsp;&nbsp;
                            <input type="radio" id="member${i-1}-tsize" name="member${i-1}-tsize" value="XL">
                            <label for="member${i-1}-tsize">XL</label> &nbsp;&nbsp;
                            <input type="radio" id="member${i-1}-tsize" name="member${i-1}-tsize" value="XXL">
                            <label for="member${i-1}-tsize">XXL</label> &nbsp;&nbsp;
                        </div>
                </div>
            `;

            teamMembersDiv.appendChild(memberDiv);

            // States array
            const states = [
                "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh", 
                "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jharkhand", 
                "Karnataka", "Kerala", "Madhya Pradesh", "Maharashtra", "Manipur", 
                "Meghalaya", "Mizoram", "Nagaland", "Odisha", "Punjab", 
                "Rajasthan", "Sikkim", "Tamil Nadu", "Telangana", "Tripura", 
                "Uttar Pradesh", "Uttarakhand", "West Bengal",
                "Andaman and Nicobar Islands", "Chandigarh", "Dadra and Nagar Haveli and Daman and Diu", "Lakshadweep", "Delhi", "Puducherry"
            ];

            // Apply autocomplete to the unique state search box
            $(`#${stateSearchId}`).autocomplete({
                source: states,
                minLength: 2
            });

            const years = ['1st Year', '2nd Year', '3rd Year', '4th Year'];

            const yearDropdownM = memberDiv.querySelector('select[name$="-year"]');
                years.forEach((year, index) => {
                    let option = document.createElement('option');
                    option.value = index + 1; // Value is 1, 2, 3, 4 corresponding to the year
                    option.textContent = year;
                    yearDropdownM.appendChild(option);
                });
        }
    }

    // Increase team size
    increaseBtn.addEventListener('click', () => {
        let teamSize = parseInt(teamSizeInput.value);
        if (teamSize < maxTeamSize) {
            teamSize++;
            teamSizeInput.value = teamSize;
            updateTeamMembers();
        }
    });

    // Decrease team size
    decreaseBtn.addEventListener('click', () => {
        let teamSize = parseInt(teamSizeInput.value);
        if (teamSize > 1) {
            teamSize--;
            teamSizeInput.value = teamSize;
            updateTeamMembers();
        }
    });

    // Initialize team members on page load
    updateTeamMembers();

    // States for the team lead
    $(document).ready(function() {
        const states = [
            "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh", 
            "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jharkhand", 
            "Karnataka", "Kerala", "Madhya Pradesh", "Maharashtra", "Manipur", 
            "Meghalaya", "Mizoram", "Nagaland", "Odisha", "Punjab", 
            "Rajasthan", "Sikkim", "Tamil Nadu", "Telangana", "Tripura", 
            "Uttar Pradesh", "Uttarakhand", "West Bengal",
            "Andaman and Nicobar Islands", "Chandigarh", "Dadra and Nagar Haveli and Daman and Diu", "Lakshadweep", "Delhi", "Puducherry"
        ];

        // Use jQuery UI autocomplete for search
        $('#state-search').autocomplete({
            source: states,
            minLength: 2
        });
    }); 
</script>

<script>
    document.getElementById('registrationForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const teamid = document.getElementById('team-id').value.toUpperCase();
        const teamSize = parseInt(document.getElementById('teamSize').value, 10);
        const teamname = document.getElementById("team-name").value.toUpperCase();
        const yearMapping = {
            1: '1st Year',
            2: '2nd Year',
            3: '3rd Year',
            4: '4th Year'
        };
        let leadCollege = document.getElementById('lead-college').value.toUpperCase();
        if (leadCollege === 'OTHER') {
            leadCollege = document.getElementById('otherCollege').value.toUpperCase();
        }
        const leadYearInput = parseInt(document.getElementById('year').value, 10);
        const leadYear = yearMapping[leadYearInput] || '';
        const leadFood = document.querySelector('input[name="lead-food"]:checked');
        const leadFoodValue = leadFood ? leadFood.value.toUpperCase() : '';
        const leadTsize = document.querySelector('input[name="lead-tsize"]:checked');
        const leadTsizeValue = leadTsize ? leadTsize.value.toUpperCase() : ''; 

        const registrationDetails = {
            "event_id": "9b4c7e35-879a-480b-a2e5-15db8c25906d",
            "registration_tz": "Asia/Kolkata",
            "registration_details": {
            "22733": [
                {
                "name": document.getElementById('lead-name').value.toUpperCase(),
                "email_id": document.getElementById('lead-email').value.toLowerCase(),
                "country_code": "in",
                "dial_code": "+91",
                "phone_number": document.getElementById('lead-phone').value,
                "custom_forms": {
                    "48941": teamname,
                    "48942": leadCollege,
                    "48975": teamid,
                    "48989": document.getElementById('state-search').value.toUpperCase(),
                    "48990": document.getElementById('lead-roll').value.toUpperCase(),
                    "48991": leadYear.toUpperCase(),
                    "48992": leadFoodValue,
                    "48993": leadTsizeValue
                }
                }
            ]
            }
        };

        function addTeamMember(name, email, phone, customForms) {
            const newMember = {
                "name": name,
                "email_id": email,
                "country_code": "in",
                "dial_code": "+91",
                "phone_number": phone,
                "custom_forms": customForms
            };
            registrationDetails.registration_details["22733"].push(newMember);
        }

        for (let i = 1; i < teamSize; i++) {
            const yearMapping = {
                1: '1st Year',
                2: '2nd Year',
                3: '3rd Year',
                4: '4th Year'
            };
            
            const memberNameEl = document.getElementById(`member${i}-name`);
            const memberEmailEl = document.getElementById(`member${i}-email`);
            const memberPhoneEl = document.getElementById(`member${i}-phone`) ? document.getElementById(`member${i}-phone`).value : '';
            
            // College Radio Button
            const memberCollege = document.querySelector(`input[name="member${i}-college"]:checked`);
            const memberCollegeEl = memberCollege ? memberCollege.value.toUpperCase() : '';

            // Other College Input
            const memberOtherCollegeEl = document.querySelector(`#member${i}-other-college`);
            const memberOtherCollege = memberOtherCollegeEl ? memberOtherCollegeEl.value.toUpperCase() : '';

            // State Input
            const memberStateEl = document.querySelector(`input[name="member${i}-state"]`);
            const memberState = memberStateEl ? memberStateEl.value : '';

            // Roll Number Input
            const memberRollEl = document.getElementById(`member${i}-roll`) ? document.getElementById(`member${i}-roll`).value : '';

            // Year Dropdown
            const memberYear = document.querySelector(`select[name="member${i}-year"]`);
            const memberYearValue = memberYear ? parseInt(memberYear.value, 10) : null;
            const memberYearEl = memberYearValue ? (yearMapping[memberYearValue] || '') : ''; 

            // Food Preference Radio Button
            const memberFood = document.querySelector(`input[name="member${i}-food"]:checked`);
            const memberFoodEl = memberFood ? memberFood.value.toUpperCase() : '';

            // T-shirt Size Radio Button
            const memberTsize = document.querySelector(`input[name="member${i}-tsize"]:checked`);
            const memberTshirtEl = memberTsize ? memberTsize.value.toUpperCase() : '';

            // Check if the selected college is 'OTHER' and use the other college value
            const finalCollege = (memberCollegeEl === 'OTHER' && memberOtherCollege) ? memberOtherCollege : memberCollegeEl;

            addTeamMember(
                memberNameEl.value.toUpperCase(), 
                memberEmailEl.value.toLowerCase(),
                memberPhoneEl,
                {
                    "48941": teamname,
                    "48942": finalCollege,
                    "48975": teamid,
                    "48989": memberState.toUpperCase(),
                    "48990": memberRollEl,
                    "48991": memberYearEl.toUpperCase(),
                    "48992": memberFoodEl,
                    "48993": memberTshirtEl
                }
            );
        }

        var formData = new FormData(this);

        fetch('register.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            
            return fetch('https://api.konfhub.com/event/capture/v2', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'x-api-key': '337897d8-0045-40d9-bde0-6683bf774810'
                },
                body: JSON.stringify(registrationDetails)
            });
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            alert('Registration successful!');
            console.log(data.message);
            window.location.reload();
        })
        .catch(error => {
            console.error('API Error:', error);
            alert('There was an error with your registration. Please try again.');
        });
    });
</script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</body>
</html>
