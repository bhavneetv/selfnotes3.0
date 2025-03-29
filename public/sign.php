
<?php

require("../includes/connection.php");

if ($conn->connect_error) {


    echo " Lost";
}


else {
   
        // echo $_SERVER['REQUEST_METHOD'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        // $subject = $_POST['subject'];
        $class = ucfirst($_POST['class']);
        $role = $_POST['role'];
        $pass = md5($_POST['password']);
        // echo $name, $email, $subject, $class, $role, $pass;


        $check_u = "SELECT email FROM user WHERE email = '$email'";
        $response = $conn->query($check_u);
        if ($response->num_rows > 0) {
            // $row = $response->num_rows;
            // echo $row;
            echo '<script>alert("User Already Exist")</script>';
            echo '<script>window.location.href = "login-sign.php";</script>';
        } else {
            $value_add = "INSERT INTO user(name, email, password, class, role)
            VALUE(
            '$name',
            '$email',
            '$pass',
            '$class',
            '$role'
            )";

            if ($conn->query($value_add)) {
                echo '<script>alert("Account created successfully")</script>';
   
                setcookie("subject" ,  $email ,time() + 60*60*24 , "/");
                setcookie("User" ,  $email ,time() + 60*60*24*3 , "/");
                setcookie("login_time", time(), time() + (86400 * 30), "/"); // 30 days
                // echo $role;

                if($role == "Student"){
                    header("Location:subjectUpload.php");
                    echo '<script>window.location.href = "subjectUpload.php";</script>';

                }
                else{
                    header("Location:../teacher/teacherMain.php");
                }
                
            
        }

        // Check if subjects are selected
      
    }
}




?>
