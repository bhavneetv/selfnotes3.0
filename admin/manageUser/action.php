<?php


session_start();

if (empty($_SESSION["User"])) {


    header("Location: ../../public/login-sign.php");
    exit();
}


require("../../includes/connection.php");
$v = $_SESSION["User"];

$note = $_POST["id"];

$getID = "SELECT * FROM `user` WHERE email = '$v'";
$getIDRes = $conn->query($getID);
if($getIDRes->num_rows > 0) {
    $row = $getIDRes->fetch_assoc();
    $name = $row["id"];
    $role = $row["role"];


    if($role == "Admin" ){

        if($name == $note){
            echo "You cannot delete yourself";
            exit();
        }else{
            $sql = "DELETE FROM user WHERE id = '$note'";
            if($conn->query($sql) === TRUE){
               echo "yes";
                exit();
            }else{
                echo "failed";
                exit();
            }
        }
    }
    else{
        echo "Not Permission To delete";
    }


}













?>