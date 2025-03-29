<?php

session_start();
require("../../includes/connection.php");


if (empty($_SESSION['User'])) {
    $course = "btech(cse)";
} else {

    $v = $_SESSION['User'];
    $ex_name = "SELECT * FROM user WHERE email = '$v' ";
    $res = $conn->query($ex_name);

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        // print_r($row['Full_name']);
        $course = $row['class'];
    } else {
        $course = "btech(cse)";
    }
}

// Fetch notes from the database
$subject = $_GET['subject'];
// $subject = "Biology";
$sql = "SELECT * FROM all_notes WHERE subject = '$subject' AND course = '$course' AND approve = '1' AND type = 'syb'";


// echo $sql;
$result = $conn->query($sql);


$notes = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notes[] = $row;
    }
}


// echo $notes;
// echo $subject . '<br>';
// echo $course . '<br>';
// echo $result->num_rows;
// Close connection
$conn->close();

// Return notes as JSON
header('Content-Type: application/json');
echo json_encode($notes);
