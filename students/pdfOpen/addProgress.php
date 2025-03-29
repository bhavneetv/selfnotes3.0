<?php

require("../../includes/connection.php");
session_start();

if (!empty($_SESSION['User'])) {
   
    $v = $_SESSION['User'];
    $id = $_POST['id'];
    $sql = "SELECT * FROM user WHERE email = '$v'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentValue = $row["progress"];

        if ($currentValue == "no") {
       
            $updatedValue = $id;
        } else  {
          
            $updatedValue = $currentValue . "," . $id;
        } 

        // Update the database with the new value
        $updateQuery = "UPDATE user SET progress = '$updatedValue' WHERE email = '$v'";
        if ($conn->query($updateQuery) === TRUE) {
            echo "yes";
        } else {
            echo "guest" ;
        }
        
    } 

    
}
else{
    echo "guest";
}



// Close the connection
$conn->close();
