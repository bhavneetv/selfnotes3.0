<?php

session_start();
require("../includes/connection.php");

if(empty($_COOKIE["subject"])) {


    header("Location: login-sign.php");

}

else{
    $User = $_COOKIE["subject"];
    $subjr = $_POST["subject"];
    // echo $subjr;
    $sql = "UPDATE user SET subject = '$subjr' WHERE email = '$User'";
    $c = $conn->query($sql);
    if($c){
        echo"yes";
        // setcookie("subject" ,  $User ,time() - 60*60*24 , "/");
    }
    else{
        echo "Failed";
    }
}






















?>