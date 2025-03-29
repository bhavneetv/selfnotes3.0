<?php

require("../../../includes/connection.php");
session_start();

if ($conn->connect_error) {


    echo " Lost";
} else {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $input = $_POST['input'];
        // $input = ;
        $room_name = $_POST['room'];
        $user = $_SESSION['User'];
        // echo $room_name;
        // echo $input;


        if (strlen($input) < 1) {
            echo 'no';

        }
         else {
            $get_id_qu = "SELECT * FROM `user` WHERE email = '$user'";
            $res = $conn->query($get_id_qu);
            if ($res->num_rows > 0) {
                $row = $res->fetch_assoc();
                $user_id = $row["id"];
                $input = base64_encode($input);





                $value_add = "INSERT INTO msgs(room_name,sender,msg_text)
            VALUE(
            '$room_name',
            '$user_id',
            '$input'
            )";

                if ($conn->query($value_add)) {
                    // echo '<script>window.location = ../chat-box.php?room_name='.$name.' </script>';
                    // header()
                    echo 'yes';

                } else {
                    echo 'no';
                }

            }
        }
    } else {

        echo 'no';
    }



}



?>