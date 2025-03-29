<?php


require("../includes/connection.php");
session_start();
if ($conn -> connect_error) {
   

    echo "Connection Lost";
}
else{
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        // echo $_SERVER['REQUEST_METHOD'];
        // $name = $_POST['full_name'];
        $email = $_POST['email'];
        $pass = md5($_POST['password']);

     
      
       
        $check_u = "SELECT email FROM user WHERE email = '$email' ";
        $response = $conn->query($check_u);       
        if($response->num_rows > 0){
            $check_p = "SELECT email FROM user WHERE email = '$email' AND password = '$pass' ";
            $check_r = "SELECT role FROM user WHERE email = '$email' ";
            $responses = $conn->query($check_p);
            if($responses->num_rows > 0){
                $response = $conn->query($check_r);
                $row = $response->fetch_assoc();
                
            
                
                if(isset($_POST['keep'])){

                    // echo '<script>alert("on")</script>';
                    $_SESSION['User'] = $email;
                    setcookie("login_time", time(), time() + (86400 * 30), "/"); // 30 days
                    setcookie("User" ,  $email ,time() + 60*60*24*14 , "/");
                    // header("Location:../../index.php");
                    
                    // echo '<script>window.location.href = "../../index.php";</script>';
                    
                }
                else{
                    
                    $_SESSION['User'] = $email;
                    setcookie("login_time", time(), time() + (86400 * 30), "/"); // 30 days
                    // echo '<script>alert('.$_POST['keep'].')</script>';
                    // echo '<script>alert("Logined")</script>';
                  
                    // header("Location:../../index.php");
                }

                if($row['role'] == "Admin"){

                    header("Location:../admin/adminMain.php");
                    
                }
                elseif($row['role'] == "Teacher"){

                    header("Location:../teacher/teacherMain.php");
                    
                }
                else{
                    
                    echo '<script>window.location.href = "../students/index.php";</script>';

                }

                
            }
            else{
                echo '<script>alert("Password Incorrect")</script>';
                echo '<script>window.location.href = "login-sign.php";</script>';
                // header("Location:login-sign.php");
                // header("Location:../../index.php");
            }
        }
        else{
            echo '<script>alert("User Not Registered")</script>';
            echo '<script>window.location.href = "login-sign.php";</script>';
            // header("Location:login-sign.php");
         }
        
    }
    else{
        // echo $_SERVER['REQUEST_METHOD'];
        // echo "User Not authorised";
        echo '<script>alert("User Not Authorised")</script>';
    }
}



?>
