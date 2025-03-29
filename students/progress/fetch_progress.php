<?php
require("../../includes/connection.php");
session_start();
// Example string of IDs
if(empty($_SESSION['User'])){
    $idString = 'g';
}else{
    $v = $_SESSION['User'];
    $qua = "SELECT * FROM user WHERE email = '$v'";
    $res = $conn->query($qua);

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $progress = $row['progress'];

        $subject = $row['subject'];
    }else{
        echo "Error";
    }
}
$idString = $progress;

// Convert string into an array and sanitize
$idArray = explode(",", $idString);
$idList = implode(",", array_map('intval', $idArray)); // Ensures IDs are integers

// List of subjects to filter dynamically (Can be increased without code changes)
$subject = explode(",", $subject);
// print_r($subject);
$filterSubjects = $subject;

// Fetch subjects from database
$sql = "SELECT subject FROM all_notes WHERE id IN ($idList)";
$result = $conn->query($sql);

// Dynamic associative array to store counts
$subjectCounts = array_fill_keys($filterSubjects, 0); // Auto-creates keys with 0 count

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        foreach ($filterSubjects as $filter) {
            if (stripos($row['subject'], $filter) !== false) {
                $subjectCounts[$filter]++;
            }
        }
    }
}

// Remove subjects with zero count (optional)
// $subjectCounts = array_filter($subjectCounts);

// Output the counts in JSON format
echo json_encode($subjectCounts, JSON_PRETTY_PRINT);

// Close connection
$conn->close();
?>
