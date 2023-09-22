<?php
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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dept_code = $_POST["dept_code"];
    $dept_name = $_POST["dept_name"];
    $courses = $_POST["courses"];
    $semester = $_POST["semester"];
    $student = $_POST["student"];
    $credit =$_POST["credit"];



    // Update the student data in the database
    $sql = "UPDATE courses SET course_code='$dept_code', course_name='$dept_name', department='$courses', semester='$semester', totall_credit='$student', totall_students= '$credit' WHERE course_code= '$dept_code' ";

    if ($conn->query($sql) === TRUE) {
        echo "Course data updated successfully.";
    } else {
        echo "Error updating Course data: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>