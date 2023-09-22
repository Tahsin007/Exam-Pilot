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
    $dept_code = $_POST["dept_code"];
    $dept_name = $_POST["dept_name"];
    $courses = $_POST["courses"];
    $semester = $_POST["semester"];
    $student = $_POST["student"];
    $credit =$_POST["credit"];



    $sql = "UPDATE department SET dept_code='$dept_code', dept_name='$dept_name', totall_courses='$courses', totall_semester='$semester', totall_student='$student', totall_credit= '$credit' WHERE dept_code= '$dept_code' ";

    if ($conn->query($sql) === TRUE) {
        echo "Department data updated successfully.";
    } else {
        echo "Error updating department data: " . $conn->error;
    }
}

$conn->close();
?>