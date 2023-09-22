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
    $deptCode = $_POST["deptCode"];
    $deptName = $_POST["deptName"];
    $courses = $_POST["courses"];
    $semester = $_POST["semester"];
    $students = $_POST["students"];
    $credit = $_POST["credit"];

    $sql = "INSERT INTO department (dept_code, dept_name, totall_courses, totall_semester, totall_student, totall_credit)
            VALUES ('$deptCode', '$deptName', '$courses', '$semester', '$students', '$credit')";

    $conn->query($sql);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
   

</body>

</html>