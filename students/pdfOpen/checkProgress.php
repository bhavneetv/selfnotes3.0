<?php

require("../../includes/connection.php");
session_start();

if (!empty($_SESSION['User'])) {
   
    $v = $_SESSION['User'];
   
    $sql = "SELECT * FROM user WHERE email = '$v'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentValue = $row["progress"];
        echo $currentValue;

      
    } 
    else{
        echo "guest";
    }
    
}
else{
    echo "guest";
}



// Close the connection
$conn->close();
