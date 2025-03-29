<?php

// $db = new mysqli("localhost", "root", "", "self_notes");require("../../../php/data.php");
require("../../includes/connection.php");
session_start();
if ($conn->connect_error) {


    echo "Connection Lost";
} else {
    if(empty($_COOKIE["forgot_email"])){
        echo "e";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // echo $_SERVER['REQUEST_METHOD'];
        $l = md5($_POST['otp']);
        $lp = $_COOKIE["forgot_email"];
        date_default_timezone_set('Asia/kolkata');
        $code_e = date('Y-m-d');

        // $m = $_SESSION['forgot_pass'];
        $q = "SELECT email FROM `user` WHERE email = '$lp' AND forgot_code = '$l' AND code_expire = '$code_e'";
        $r = $conn->query($q);
        if ($r->num_rows > 0) {
            echo "yes";
            // exit();

        } else {
            echo "Worng OTP";
        }

    } else {
        echo '<script>alert("Try Again")</script>';

    }









}











?>