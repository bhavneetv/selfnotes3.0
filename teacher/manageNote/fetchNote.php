<?php

session_start();
require("../../includes/connection.php");



// $subject = "Biology";
$sql = "SELECT * FROM all_notes WHERE author_mail = '$_SESSION[User]'";


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
