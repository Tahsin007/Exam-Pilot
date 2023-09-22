<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam pilot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
// }

// Assuming you have received the semester and course code from a form
$semester = $_POST["semester"]; // Replace with the actual form field name
$courseCode = $_POST["course_code"]; // Replace with the actual form field name

// Prepare the SQL query
$sql = "SELECT
    students.student_id,
    attendance.course_code,
    SUM(CASE WHEN attendance.status = 'present' THEN 1 ELSE 0 END) AS present_count,
    SUM(CASE WHEN attendance.status = 'absent' THEN 1 ELSE 0 END) AS absent_count
FROM
    students
LEFT JOIN
    attendance ON students.student_id = attendance.student_id
WHERE
    students.semester = '$semester' 
    AND attendance.course_code = '$courseCode'
GROUP BY
    students.student_id, attendance.course_code";


$result = $conn->query($sql);
// // Prepare and bind parameters
// $stmt = $conn->prepare($sql);
// // $stmt->bind_param("ss", $semester, $courseCode);

// // Execute the query
// $stmt->execute();

// // Get the results
// $result = $stmt->get_result();

// Check if there are any results
if ($result->num_rows > 0) {
    // Output the data in a table
    echo "<table>";
    echo "<tr><th>Student ID</th><th>Course Code</th><th>Present Count</th><th>Absent Count</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["student_id"] . "</td>";
        echo "<td>" . $row["course_code"] . "</td>";
        echo "<td>" . $row["present_count"] . "</td>";
        echo "<td>" . $row["absent_count"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}

// Close the database connection
// $stmt->close();
$conn->close();
?>