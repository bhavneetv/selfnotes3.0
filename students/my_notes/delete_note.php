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
            
            $note_name = $_POST['id'];
            // echo  $note_name , $inp;
            $today_time = date("Y-m-d H:i:s");
            $time = $note_name."_edit";



            $check =  "SELECT * FROM `my_notes` WHERE owner = '$user' ";
            $check_r = $conn->query($check);
            if ($check_r->num_rows > 0) {   
               
                $q = "UPDATE `my_notes` SET `$note_name` =  '' , `$time` = '$today_time' WHERE owner = '$user' ";
                $r = $conn->query($q);
                
                if ($r) {
                    echo "yes";
                   
                } 
                else {
                    echo "Failed";
                }
               
            }
            else{
                echo '<script>alert("Try Again")</script>';
            }
           
           
        } else {
            echo '<script>alert("Try Again")</script>';

        }

    }

}



?>