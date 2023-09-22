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
    $teacher_name = $_POST["teacher_name"];
    $email = $_POST["email"];
    $contact = $_POST["contact"];
    $password = $_POST["password"];
    $dept_name = $_POST["dept_name"];
    $teacher_id = $_POST["teacher_id"];



    // Update the student data in the database
    $sql = "UPDATE faculties SET teacher_name='$teacher_name', email_id='$email', contact='$contact', dept_name='$dept_name', password='$password'  WHERE teacher_id= '$teacher_id' ";

    if ($conn->query($sql) === TRUE) {
        echo "Teacher data updated successfully.";
    } else {
        echo "Error updating Teacher data: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
