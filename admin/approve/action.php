<?php


session_start();

if (empty($_SESSION["User"])) {


    header("Location: ../../public/login-sign.php");
    exit();
}

require("../../includes/connection.php");

$note = $_POST["id"];
$action = $_POST["action"];

if($action == "approve"){
    $sql = "UPDATE all_notes SET approve = '1' WHERE id = '$note'";
}
else{
    $sql = "DELETE FROM `all_notes` WHERE id = '$note'";
}

if(mysqli_query($conn, $sql)){
    echo "yes";
}else{
    echo "failed";
}















?>