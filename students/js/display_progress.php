<?php
session_start();
require("../../includes/connection.php");

// Example string of IDs

if(empty($_SESSION['User'])){
    $idString = 'g';
    $progress = '0';
}

else{

    $v = $_SESSION['User'];
    $qua = "SELECT * FROM user WHERE email = '$v'";
    $res = $conn->query($qua);

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $progress = $row['progress'];
    }else{
        echo "Error";
        $progress = '0';
    }
}
$idString = $progress;

$sub = $_POST['sub'];

// Convert string into an array
$idArray = explode(",", $idString);

// Sanitize and prepare IDs for SQL query
$idList = implode(",", array_map('intval', $idArray)); // Ensures IDs are integers

// SQL Query to fetch subjects for matching IDs
$sql = "SELECT subject FROM all_notes WHERE id IN ($idList)";
$result = $conn->query($sql);

// Counter for subjects containing "Science"
$subjectCount = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Check if "Science" is in the subject
        if (stripos($row['subject'], $sub) !== false) {
            $subjectCount++;
        }
    }
}

// Output the count
echo " $subjectCount";

// Close connection
$conn->close();
?>
