<?php

$servername = "localhost"; // Change if needed
$username = "root"; // Your database username
$password = ""; // Your database password
$database = "self_note3"; // Your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
