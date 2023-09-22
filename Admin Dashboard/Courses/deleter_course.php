<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam pilot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET["course_code"])) {
    $course_code = $_GET["course_code"];

    $sql = "DELETE FROM courses WHERE course_code = '$course_code'";

    if ($conn->query($sql) === TRUE) {
        echo "Course record deleted successfully.";
    } else {
        echo "Error deleting Course record: " . $conn->error;
    }
}

$conn->close();
?>
