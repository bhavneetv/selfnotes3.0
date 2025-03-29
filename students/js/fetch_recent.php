<?php

session_start();
require("../../includes/connection.php");


if (!empty($_SESSION['User'])) {
    $v = $_SESSION['User'];
    $sqll = "SELECT recent_note FROM user WHERE email = '$v'";
    $resultt = $conn->query($sqll);
    if ($resultt->num_rows > 0) {
        $row = $resultt->fetch_assoc();
        $recent = $row['recent_note'];
        if ($recent == '') {
            $recent = '';
        }
    } else {
        $recent = '';
    }
} else {

    $sql = "SELECT id FROM all_notes WHERE approve = '1' AND course = 'btech(cse)' AND type = 'notes' ORDER BY RAND() LIMIT 5";
    $result = $conn->query($sql);
    
    $randomNotes = [];
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $randomNotes[] = $row['id'];
        }
        $recent = implode(",", $randomNotes);
    }
    else{
        $sql = "SELECT id FROM all_notes WHERE approve = '1' AND course = 'btech(cse)'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc() ;
            $recent = $row['id'];
            
        }
    }
    
    // Convert the array to a comma-separated string

   


    // echo $recent;

    // $recent = '30,23,14,22';

}



// Example string of IDs
$idString = $recent;

// Convert string into an array
$idArray = explode(",", $idString);
$uniqueNumbers = array_values(array_unique($idArray));

// Get only the first 5 numbers
$firstFive = array_slice($uniqueNumbers, 0, 5);


// Sanitize and prepare IDs for SQL query
$idList = implode(",", array_map('intval', $firstFive)); // Ensure IDs are integers

// SQL Query to fetch matching records
$sql = "SELECT * FROM all_notes WHERE id IN ($idList)";
$result = $conn->query($sql);

// Store results in an array
$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Convert the array to JSON format
echo json_encode($data, JSON_PRETTY_PRINT);

// Close connection
$conn->close();
