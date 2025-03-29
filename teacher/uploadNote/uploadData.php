<?php

require("../../includes/connection.php");
session_start();

$title = ucfirst($_POST['title']);
$subject = ucfirst($_POST['subject']);

$course = ucfirst($_POST['course']);
// $note = $_POST['note']; 
$type = $_POST['type'];
$mainTopics = ucfirst($_POST['mainTopics']);
$link = $_POST['link'];
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


$sql = "INSERT INTO all_notes (type,title, subject, course, description, chapter, uploaded_By, uploaded_time, link ,topic_id,approve,author_mail) VALUES ('$type','$title', '$subject', '$course', '$description', '$chapterNumber', '$name', '$date', '$link', '$mainTopics','$approved','$user')";

if ($link != "") {

    $v = $conn->query($sql);
    if ($v) {
        echo "yes";
    }
}
