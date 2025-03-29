<?php

require("../../../includes/connection.php");
session_start();

if ($conn->connect_error) {


    echo " Lost";
} else {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {


        $room = $_POST['input'];
        $type = $_POST['do'];
        $user = $_SESSION['User'];

        $check_q = "SELECT * FROM `room_check` WHERE room_name = '$room'";
        $res = $conn->query($check_q);
        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $owner = $row["owner"];

            if ($owner == $user) {

                $clear_q = "DELETE  FROM `msgs` WHERE room_name = '$room'";

                $res = $conn->query($clear_q);
                if ($res) {
                    echo 'yes';


                    if ($type == 'del') {
                        $del_q = "DELETE  FROM `room_check` WHERE room_name = '$room'";
                        $resf = $conn->query($del_q);
                        if ($resf) {
                            echo 'del';


                        }
                    }
                } else {
                    echo 'no';
                }


            } else {
                echo 'Not Owner';
            }
        } else {
            echo 'Room Not Found';
        }

















    } else {

        echo 'User Not Authorised';
    }



}



?>