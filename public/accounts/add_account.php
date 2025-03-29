<?php
session_start();
require("../../includes/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $subjects = isset($_POST['subject']) ? $_POST['subject'] : [];

    $subjectString = implode(',', $subjects);

    
    $stmt = $conn->prepare("UPDATE user SET subject = ? WHERE email = ?");
    
   
    $email = $_SESSION['User'];

    
    $stmt->bind_param("ss", $subjectString, $email);

    
    if ($stmt->execute()) {
        header("Location: account.php");
    } else {
        echo "Error updating subjects: " . $stmt->error;
    }

    $stmt->close();
}

// Close
$conn->close();
?>