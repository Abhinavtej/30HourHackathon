<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "Admin" && $_SESSION["user"]["role"] !== "Dean") {
    header("Location: login.php");
    exit();
}

require_once "database.php";

$file_id = isset($_GET['teamid']) ? $_GET['teamid'] : '';

if ($file_id) {
    $sql = "SELECT files FROM payment WHERE teamid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $file_id);
    $stmt->execute();
    $stmt->bind_result($pdf);
    $stmt->fetch();
    header("Content-Type: image/jpeg");
    echo $pdf;
}
    $stmt->close();
    $conn->close();
?>