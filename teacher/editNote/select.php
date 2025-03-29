<?php
include '../../includes/connection.php'; // Include your database connection file

$course = isset($_POST['course']) ? $_POST['course'] : ''; // Get selected course

$subjects = [];
$custom_subjects = [];

// Fetch subjects from all_notes table (type = 'subject')
$query1 = "SELECT subject FROM all_notes WHERE course = ?";
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("s", $course);
$stmt1->execute();
$result1 = $stmt1->get_result();

if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        $links = explode(',', $row['subject']); // Split comma-separated values
        foreach ($links as $link) {
            $custom_subjects[] = trim($link);
        }
    }
}

// Fetch subjects from all_notes table where course matches and type = 'subject'
$query2 = "SELECT link FROM all_notes WHERE course = ? AND type = 'subject'";
$stmt = $conn->prepare($query2);
$stmt->bind_param("s", $course);
$stmt->execute();
$result2 = $stmt->get_result();

if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
        $links = explode(',', $row['link']); // Split comma-separated values
        foreach ($links as $link) {
            $subjects[] = trim($link);
        }
    }
}

// Merge both arrays
$mergedSubjects = array_merge($subjects, $custom_subjects);

// Remove empty values, duplicates, and sort alphabetically
$mergedSubjects = array_filter($mergedSubjects, fn($value) => !empty($value));
$mergedSubjects = array_unique($mergedSubjects);
sort($mergedSubjects);

// If no subjects found, set default subjects (Any 10 subjects)
if (empty($mergedSubjects)) {
    $mergedSubjects = ["Physics", "Mathematics", "Biology", "Chemistry", "English", "History", "Science", "MP", "Hindi", "Economics"];
}

// Return JSON response for AJAX
echo json_encode(array_values($mergedSubjects));
?>
