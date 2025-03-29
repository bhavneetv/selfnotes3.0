<?php

// $db = new mysqli("localhost", "root", "", "self_notes");require("../../../php/data.php");
require("../../includes/connection.php");
session_start();

if ($conn->connect_error) {

    echo "Connection Lost";

} else {

    if (empty($_SESSION["User"])) {
        echo 'guest';


    } else {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $user = $_SESSION['User'];
            $inp = $_POST['name'];
            $note_name = $_POST['id'];
            $note_name = $note_name."_name";

            // echo $inp;
       



          
               
                $q = "UPDATE `my_notes` SET `$note_name` =  '$inp'   WHERE owner = '$user' ";
                $r = $conn->query($q);
                
                if ($r) {
                    echo "yes";
                   
        
                } 
                else {
                    echo "Failed";
                }
               
           
           
           
        } else {
            echo '<script>alert("Try Again")</script>';

        }

    }

}



?>