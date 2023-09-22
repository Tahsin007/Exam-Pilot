<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam pilot";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $deptName = $_POST["deptName"];
    $semester = $_POST["semester"];
    $courseCode = $_POST["courseCode"];


    // Prepare and execute an SQL INSERT statement
    $sql = "SELECT * FROM student_marks as m JOIN students as s ON m.student_id = s.student.id";
    $result = $conn->query($sql);

    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
