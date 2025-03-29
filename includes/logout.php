<?php
session_start();

require("connection.php");


$v = $_SESSION["User"];

setcookie('User', "", time() - 3600, "/");
$login_time = $_COOKIE['login_time'];
$logout_time = time();

// Calculate minutes spent
$minutes_spent = round(($logout_time - $login_time) / 60, 2);

// get past 

// Update study hours in the database

$query = "UPDATE user SET total_time = total_time + ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("di", $minutes_spent, $v);
$stmt->execute();

// Clear the cookie
setcookie("login_time", "", time() - 3600, "/");
unset($_SESSION["User"]);
header("Location:../public/login-sign.php");
