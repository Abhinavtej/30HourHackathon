<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION["user"])) {
   header("Location: login.php");
}

$role = $_SESSION["user"]["role"];
switch ($role) {
    case "Dean":
        header("Location: dean.php");
        break;
    case "Admin":
        header("Location: admin.php");
        break;
    default:
        break;
}
exit();
?>