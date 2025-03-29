<?php

// $db = new mysqli("localhost", "root", "", "self_notes");require("../../../php/data.php");
require("../../includes/connection.php");
session_start();

if ($conn->connect_error) {

    echo "Connection Lost";

} else {

    if(empty($_SESSION["User"])) {
        echo 'guest';


    }
    else{

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user = $_SESSION['User'];
        $note = $_POST["id"];
        // echo $user;

        $q = "SELECT * FROM `my_notes` WHERE owner = '$user' ";
        
        $r = $conn->query($q);
        if ($r->num_rows > 0) {
            $row = $r->fetch_assoc();
            print_r(base64_decode($row[$note]));

        }
        else{
            echo 'Start Writting ..................';
        }
    } 
    else {
        echo '<script>alert("Try Again")</script>';

    }

}

}



?>