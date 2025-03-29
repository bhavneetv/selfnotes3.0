<?php

require("../../includes/connection.php");
session_start();

$id = $_COOKIE['Edit_note'];

$title = ucfirst($_POST['title']);
$subject = ucfirst($_POST['subject']);

$course = ucfirst($_POST['course']);
// $note = $_POST['note']; 
$type = $_POST['type'];
$mainTopics = ucfirst($_POST['mainTopics']);
// $link = $_POST['link'];
$subOther = ucfirst($_POST['subOther']);


$courseOther = ucfirst($_POST['courseOther']);
$description = ucfirst($_POST['description']);
$chapterNumber = ucfirst($_POST['chapterNumber']);
$user = $_SESSION['User'];
$date = date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d H:i:s');

$ex_name = "SELECT * FROM user WHERE email = '$user' ";
$res = $conn->query($ex_name);

if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $name = $row['name'];

    $role = $row['role'];
}



if ($course == "other") {
    $course = $courseOther;
}
if ($subject == "Other") {

    $subject = $subOther;
}

// echo $course . "<br>" . $subject;
// echo $subOther;
if($role == "Admin"){
    $approved = "1";
    $name = "Admin";

}
else{
    $approved = "0";
}


$sql = "UPDATE all_notes SET type = '$type', title = '$title', subject = '$subject', course = '$course', description = '$description', chapter = '$chapterNumber', uploaded_time = '$date', topic_id = '$mainTopics', approve = '$approved' WHERE id = '$id'";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
    setcookie("Edit_note", "", time() - 3600, "/");
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
