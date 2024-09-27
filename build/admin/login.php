<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST["login"])) {
    $username = strtoupper($_POST["username"]);
    $password = $_POST["password"];

    require_once "database.php";

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($password, $user["password"])) {
            $_SESSION["user"] = [
                "username" => $user["username"],
                "name" => $user["name"],
                "role" => $user["role"]
            ];

            switch ($user["role"]) {
                case "Dean":
                    header("Location: dean.php");
                    exit();
                case "Admin":
                    header("Location: admin.php");
                    exit();
                default:
                    $error = "Incorrect username or password";
            }
        } else {
            $error = "Incorrect username or password";
        }
    } else {
        $error = "User not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        body {
            font-family: 'Jost', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #F0F8FF;
        }
        .container {
            max-width: 400px;
            height: auto;
            text-align: center;
            padding: 30px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }
        .logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 2vh;
        }
        .btn {
            width: 100%;
        }
        @media screen and (max-width: 990px) {
            .container {
                width: 90%;
                max-width: 600px;
            }
            #dept {
                width: 75%;
                height: 15px;
            }
            #mru{
                width: 75%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="MRU-Logo.png" id="mru" alt="Logo" width="50%" height="50" style="margin: 0 0 3vh 0">
            <img src="Dept.png" id="dept" alt="Logo" width="75%" height="20" style="margin: 0 0 3vh 0">
        </div>
        <?php if (isset($error)) : ?>
            <div class='alert alert-danger'><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="login.php" method="post">
            <div class="form-floating mb-3">
                <input type="text" placeholder="Username" id="floatingInput" name="username" class="form-control" required>
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating mb-4">
                <input type="password" placeholder="Password" id="floatingPassword" name="password" class="form-control" required>
                <label for="floatingPassword">Password</label>
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>
    </div>
</body>
</html>
