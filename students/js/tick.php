<?php

session_start();
require("../../includes/connection.php");


if (!empty($_SESSION['User'])) {
    $v = $_SESSION['User'];
    $sqll = "SELECT progress FROM user WHERE email = '$v'";
    $resultt = $conn->query($sqll);
    if ($resultt->num_rows > 0) {
        $row = $resultt->fetch_assoc();
        $recent = $row['progress'];
       
    }
    else{
        $recent = '0';
        
    }
} 
else {
 
    $recent = '0';
  
}

echo $recent;



// Close connection
$conn->close();
