<?php
// Database connection (Update with your credentials)
require("../../includes/connection.php");
session_start();

$id = $_POST['id'];
if (!empty($_SESSION['User'])) {
   
    $v = $_SESSION['User'];
    $id = $_POST['id'];
    $sql = "SELECT * FROM user WHERE email = '$v'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentValue = $row["recent_note"];

        if ($currentValue == "no") {
       
            $updatedValue = $id;
        } else  {
          
            $updatedValue = $currentValue . "," . $id;
        } 

        // Update the database with the new value
        $updateQuery = "UPDATE user SET recent_note = '$updatedValue' WHERE email = '$v'";

        if ($conn->query($updateQuery) === TRUE) {

            echo "Updated value: $updatedValue";
        } else {
            echo "Error updating record: " . $conn->error;
        }

        // $sqlCheck = "SELECT * FROM all_notes WHERE id = '$id'";
        // $result = $conn->query($sqlCheck); 
        // if($result->num_rows > 0){
        //     $row = $result->fetch_assoc();
        //     $currentValue = $row["view"];

        //     $newValue = $currentValue + 1;

        //     $sqlUpdate = "UPDATE all_notes SET view = '$newValue' WHERE id = '$id'";
        //     if($conn->query($sqlUpdate) === TRUE){
        //         echo "Updated value: $newValue";
        //     } else {
        //         echo "Error updating record: " . $conn->error;
        //     }

            
            
        // }
    } 
    



}




    $sqlCheck = "SELECT * FROM all_notes WHERE id = '$id'";
    $result = $conn->query($sqlCheck); 
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $currentValue = $row["view"];

        $newValue = $currentValue + 1;

        $sqlUpdate = "UPDATE all_notes SET view = '$newValue' WHERE id = '$id'";
        if($conn->query($sqlUpdate) === TRUE){
            echo "Updated value: $newValue";
        } else {
            echo "Error updating record: " . $conn->error;
        }

        
        
    }




// Close the connection
$conn->close();
