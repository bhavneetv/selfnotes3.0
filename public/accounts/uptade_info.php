<?php
session_start();
require("../../includes/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    // $email = $_POST['email'];
    // $class = $_POST['class'];
    $user = $_SESSION['User'];
   
   $q = "UPDATE user SET name = '$name'  WHERE email = '$user'";

    if ($conn->query($q) === TRUE) {
        echo "true";
    } else {
        echo "Error updating record: " . $conn->error;
    }

  
  
}


$conn->close();
?>