<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam pilot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET["dept_code"])) {
    $dept_code = $_GET["dept_code"];

    $sql = "DELETE FROM department WHERE dept_code = '$dept_code'";

    if ($conn->query($sql) === TRUE) {
        echo "Student record deleted successfully.";
    } else {
        echo "Error deleting student record: " . $conn->error;
    }
}

$conn->close();
?>
