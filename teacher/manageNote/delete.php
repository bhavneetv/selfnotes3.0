<?php 

include('../../includes/connection.php');

$id = $_POST['sub'];
$sql = "DELETE FROM all_notes WHERE id = '$id'";
if(mysqli_query($conn, $sql)){
    echo "yes";
}else{
    echo "failed";
}















?>