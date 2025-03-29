<?php

require("../../includes/connection.php");

session_start();



if ($conn->connect_error) {
    
    
    echo " Lost";
} else {
    
    if(empty($_SESSION["User"])) {
        $sql = "DELETE FROM msgs WHERE time < DATE_ADD(NOW(),INTERVAL - 7 DAY)";
        $result = $conn->query($sql);
        
        echo '<script>window.location.href="talk.php"</script>';
    }
    
    else{
        $sql = "DELETE FROM msgs WHERE time < DATE_ADD(NOW(),INTERVAL - 7 DAY)";
        $result = $conn->query($sql);

        $user  = $_SESSION['User'];
        $name = $_GET['room_name'];
        $sql_check = "SELECT * FROM `room_check` WHERE room_name = '$name' ";
        $result = $conn->query($sql_check); 
        if($result->num_rows == 0){

            echo '<script>alert("room does not found")</script>';
            echo '<script>window.location.href="talk.php"</script>';
            
        }   
        
        else{
            $row = $result->fetch_assoc();
            $owners = $row["owner"];
            $online = $row["online"];
            
            $sql_check = "SELECT * FROM `user` WHERE email = '$owners' ";
            $result = $conn->query($sql_check); 
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $o = $row["name"];

                if($o == "Public"){
                    $o = "Admin";
                }
                
            }
            else{
                $o = "Deleted Account";
            }
        
            

            

            if($owners == $user){

                $btn = "yes";
            }
            else{
                $btn = "no";
            }
        }
        
      
        
        
        
        
        
        
        
        
        
        
        
        
    }
    
    
    
}
    
    
    
    







?>





























<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>

    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="icon" type="image/png" href="../../public/assest/icon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../../public/assest/icon/favicon.svg" />
    <link rel="shortcut icon" href="../../public/assest/icon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="../../public/assest/icon/apple-touch-icon.png" />
    <link rel="manifest" href="../../public/assest/icon/site.webmanifest" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen">
    <!-- Alert Container -->
    <!-- Sample Alert -->
    <!-- <div class="fixed top-4 right-4 z-50 space-y-2">
        <div class="bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>John Doe left the chat</span>
        </div>
    </div> -->

    <!-- Main Chat Container -->
    <div class="max-w-6xl mx-auto p-4 flex flex-col lg:flex-row gap-4">
        <!-- Chat Section -->
        <div class="flex-1">
            <!-- Chat Header -->
            <div class="bg-white dark:bg-gray-800 rounded-t-2xl shadow-lg">
                <div class="p-4 flex items-center space-x-4 border-b dark:border-gray-700">
                    <button class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors" id="backc">
                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <div class="flex-1">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white" id="room_n">Mathematics Discussion</h2>
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 space-x-2">
                            <span class="flex items-center">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                <?php echo $online; ?> online
                            </span>
                            <span>•</span>
                            <span>Created by <?php echo $o; ?></span>
                        </div>
                    </div>
                    <div class="flex space-x-2" owner="<?php echo $btn; ?>" id="box">
                        <button class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors text-blue-500" id="sh">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                            </svg>
                        </button>
                        <button class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors text-yellow-500" id="clear">
                        <svg fill="#8780e3" class="w-6 h-6" width="24px" height="24px" viewBox="0 0 1024 1024" t="1569683368540" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="9723" xmlns:xlink="http://www.w3.org/1999/xlink" stroke="#392ecf"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><defs><style type="text/css"></style></defs><path d="M899.1 869.6l-53-305.6H864c14.4 0 26-11.6 26-26V346c0-14.4-11.6-26-26-26H618V138c0-14.4-11.6-26-26-26H432c-14.4 0-26 11.6-26 26v182H160c-14.4 0-26 11.6-26 26v192c0 14.4 11.6 26 26 26h17.9l-53 305.6c-0.3 1.5-0.4 3-0.4 4.4 0 14.4 11.6 26 26 26h723c1.5 0 3-0.1 4.4-0.4 14.2-2.4 23.7-15.9 21.2-30zM204 390h272V182h72v208h272v104H204V390z m468 440V674c0-4.4-3.6-8-8-8h-48c-4.4 0-8 3.6-8 8v156H416V674c0-4.4-3.6-8-8-8h-48c-4.4 0-8 3.6-8 8v156H202.8l45.1-260H776l45.1 260H672z" p-id="9724"></path></g></svg>
                        </button>
                        <button class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors text-red-500" id="del">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Chat Messages -->
            <div class="bg-gray-50 dark:bg-gray-800 h-[60vh] overflow-y-auto p-4 space-y-4 ab" >
                <!-- System Message -->
               
            
            </div>

            <!-- Chat Input -->
            <div class="bg-white dark:bg-gray-800 rounded-b-2xl shadow-lg p-4">
                <div class="flex items-center space-x-4">
                    <button class="p-2 text-red-500 hover:bg-red-100 dark:hover:bg-red-900 rounded-xl transition-colors" id="cl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                    <input type="text" placeholder="Type a message..." id="ii" class="flex-1 px-4 py-3 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                    <button class="p-3 bg-blue-500 hover:bg-blue-600 text-white rounded-xl transition-colors" id="send">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Members Section -->
       
    </div>
</body>

<script src="js/talk2.js"></script>
</html>