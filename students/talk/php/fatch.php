<?php

require("../../../includes/connection.php");
session_start();

if ($conn->connect_error) {


    echo " Lost";
} else {

    if (empty($_SESSION['User'])) {
        echo 'guest';
    } else {



        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            // $input = $_POST['input'];
            $room_name = $_POST['room'];
            $user = $_SESSION['User'];
            $get_user_id_q = "SELECT * FROM `user` where email = '$user'";
            $res = $conn->query($get_user_id_q);
            $row = $res->fetch_assoc();
            $user_id = $row["id"];
            // echo $user_id;
            // for get msg deteail 
            $get_msg_q = "SELECT  `sender`, `msg_text`, `time` FROM `msgs` WHERE room_name = '$room_name'";
            $ress = $conn->query($get_msg_q);


            if ($ress->num_rows > 0) {




                for ($s = 0; $s <= $ress->num_rows - 1; $s++) {
                    $rowss = $ress->fetch_assoc();
                    $idd = $rowss['sender'];



                    if ($idd == $user_id) {
                        $str = $rowss['msg_text'];
                        $eco = base64_decode($str);


                        echo '<div class="flex justify-end">
                    <div class="max-w-[70%] bg-blue-500 rounded-2xl p-4 shadow-md">
                        <div class="flex items-center justify-end space-x-2">
                            <div class="text-xs text-blue-100">' . $rowss['time'] . '</div>
                            <div class="font-medium text-white">You</div>
                        </div>
                        <div class="mt-2 text-white">
                            ' . $eco . '
                        </div>
                    </div>
                </div>';
                    } elseif ($idd == 'alert') {
                        $str = $rowss['msg_text'];
                        $eco = base64_decode($str);
                        echo ' <div class="flex justify-center">
                    <div class="bg-gray-200 dark:bg-gray-700 rounded-full px-4 py-2 text-sm text-gray-600 dark:text-gray-300">
                        ' . $eco . '
                    </div>
                </div>';
                    } else {

                        $q = "SELECT * FROM `user` where id = '$idd'";
                        $resf = $conn->query($q);
                        if ($resf->num_rows > 0) {
                            $f = $resf->fetch_assoc();
                            $str = $rowss['msg_text'];
                            $eco = base64_decode($str);


                            function getInitials($name)
                            {
                                // Trim and remove extra spaces
                                $name = trim(preg_replace('/\s+/', ' ', $name));

                                // Split name into words
                                $words = explode(" ", $name);

                                // Get the first letter of the first word
                                $firstLetter = strtoupper(substr($words[0], 0, 1));

                                // Get the first letter of the last word (if exists)
                                $lastLetter = isset($words[1]) ? strtoupper(substr(end($words), 0, 1)) : '';

                                // Return initials
                                return $firstLetter ;
                            }
                            

                            echo '<div class="flex justify-start">
                                    <div class="max-w-[70%] bg-white dark:bg-gray-700 rounded-2xl p-4 shadow-md">
                                           <div class="flex items-center space-x-2">
                                                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center">
                                                  <span class="text-white font-medium">' . getInitials($f['name']) . '</span>
                                                </div>
                                                <div class="font-medium text-gray-800 dark:text-white">' . $f['name'] . '</div>
                                                <div class="text-xs text-gray-400">' . $rowss['time'] . '</div>
                                            </div>
                                            <div class="mt-2 text-gray-600 dark:text-gray-300">
                                                ' . $eco . '
                                            </div>
                                        </div>
                                    </div>';
                        } else {
                            $str = $rowss['msg_text'];
                            $eco = base64_decode($str);

                            echo '<div class="flex justify-start">
                                    <div class="max-w-[70%] bg-white dark:bg-gray-700 rounded-2xl p-4 shadow-md">
                                           <div class="flex items-center space-x-2">
                                                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center">
                                                  <span class="text-white font-medium">D</span>
                                                </div>
                                                <div class="font-medium text-gray-800 dark:text-white">Deleted User</div>
                                                <div class="text-xs text-gray-400">' . $rowss['time'] . '</div>
                                            </div>
                                            <div class="mt-2 text-gray-600 dark:text-gray-300">
                                                ' . $eco . '
                                            </div>
                                        </div>
                                    </div>';
                        }
                    }
                }
            }
        }
    }
}
