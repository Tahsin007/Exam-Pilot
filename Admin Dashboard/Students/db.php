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
    $studentId = $_POST["studentId"];
    $studentName = $_POST["studentName"];
    $emailId = $_POST["emailId"];
    $contact = $_POST["contact"];
    $deptName = $_POST["deptName"];
    $password = $_POST["password"];
    $semester = $_POST["semester"];
    $session = $_POST["session"];

    $sql = "INSERT INTO students (student_id, student_name, email_id, contact, dept_name, password,semester,session)
            VALUES ('$studentId', '$studentName', '$emailId', '$contact', '$deptName', '$password','$semester','$session')";

    $conn->query($sql);
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Data</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
   

</body>

</html>