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
    $deptName = $_POST["deptName"];
    $semester = $_POST["semester"];
    $courseCode = $_POST["courseCode"];
    $credit = $_POST["credit"];
    $courseName = $_POST["courseName"];
    $students = $_POST["students"];
    $session = $_POST["session"];
    $fid = $_POST["1st_examiner_id"];
    $sid = $_POST["2nd_examiner_id"];
    $tid = $_POST["3rd_examiner_id"];

    $sql = "INSERT INTO courses (department, semester, course_code, totall_credit, course_name, totall_students,session,1st_examiner_id,2nd_examiner_id,3rd_examiner_id)
            VALUES ('$deptName', '$semester', '$courseCode', '$credit', '$courseName', '$students','$session','$fid','$sid','$tid')";
    $conn->query($sql);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    

</body>

</html>