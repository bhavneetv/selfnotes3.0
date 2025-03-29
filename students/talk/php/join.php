<?php

require("../../../includes/connection.php");
session_start();

if ($conn->connect_error) {


    echo " Lost";
} else {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {


        $room = $_POST['input'];
        $type = $_POST['types'];
        $user = $_SESSION['User'];










        $get_id_qu = "SELECT * FROM `user` WHERE email = '$user'";
        $res = $conn->query($get_id_qu);
        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $user_id = $row["id"];
            $user_n = $row["name"];
            $con = $user_n . ' ' . $type . ' the room';
            $con = base64_encode($con);







            $value_add = "INSERT INTO msgs(room_name,sender,msg_text)
            VALUE(
            '$room',
            'alert',
            '$con'
            )";

            if ($conn->query($value_add)) {
                // echo '<script>window.location = ../chat-box.php?room_name='.$name.' </script>';

                $get_online = "SELECT online FROM room_check WHERE room_name = '$room'";
                $online = $conn->query($get_online)->fetch_assoc()['online'];
                

                if($online < 0){
                    $online = 0;
                }
               
                if($type == "leave"){
                    $online = $online - 1;
                }
                else{
                    $online = $online + 1;
                }
                $update_online = "UPDATE room_check SET online = '$online' WHERE room_name = '$room'";
              
                if(  $conn->query($update_online)){
                    echo 'yes';
                }
             
            } else {
                echo 'Failed';
            }



        }
    } else {

        echo 'User Not Authorised';
    }
}
