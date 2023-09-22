<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam pilot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentId = $_POST["student_id"];
    $studentName = $_POST["student_name"];
    $emailId = $_POST["email_id"];
    $contact = $_POST["contact"];
    $deptName = $_POST["deptName"];
    $password =$_POST["password"];
    $semester = $_POST["semester"];
    $session = $_POST["session"];


    $sql = "UPDATE students SET password='$password',semester='$semester',session='$session', dept_name='$deptName', contact='$contact', student_name='$studentName', email_id='$emailId', student_id= '$studentId' WHERE student_id= '$studentId' ";

    if ($conn->query($sql) === TRUE) {
        echo "Student data updated successfully.";
    } else {
        echo "Error updating student data: " . $conn->error;
    }
}

$conn->close();
?>