<?php
session_start();
include 'connection.php';

if (isset($_SESSION['User']) && isset($_COOKIE['login_time'])) {
    $user_id = $_SESSION['User'];
    $login_time = $_COOKIE['login_time'];
    $logout_time = time(); 

    // Calculate minutes spent
    $minutes_spent = round(($logout_time - $login_time) / 60, 2);

    // get past 

    // Update study hours in the database

    $query = "UPDATE user SET total_time = total_time + ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("di", $minutes_spent, $user_id);
    $stmt->execute();

    // Clear the cookie
    setcookie("login_time", "", time() - 3600, "/");
}
?>
