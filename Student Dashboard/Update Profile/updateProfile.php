<?php
session_start();
if (!isset($_SESSION["student_id"])) {
    header("Location: http://localhost:3000/Login/login.php"); // Redirect to the login page if not logged in
    exit();
}

// Retrieve admin details from your database based on the admin_id stored in the session
$student_id = $_SESSION["student_id"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam pilot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM students WHERE student_id = '$student_id' ";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    $student_name = $row["student_name"];
    $email_id = $row["email_id"];
    $contact = $row["contact"];
    $dept_name = $row["dept_name"];
    $password = $row["password"];
} else {
    header("Location: http://localhost:3000/Login/login.php");
    exit();
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_name = $_POST["student_name"];
    $email = $_POST["email"];
    $contact = $_POST["contact"];
    $password = $_POST["password"];
    $dept_name = $_POST["dept_name"];
    $student_id = $_POST["student_id"];



    // Update the student data in the database
    $sql = "UPDATE students SET student_name='$student_name', email_id='$email', contact='$contact', dept_name='$dept_name', password='$password'  WHERE student_id= '$student_id' ";

    if ($conn->query($sql) === TRUE) {

        
        echo "Student data updated successfully."; 
        
         
        
    } else {
        echo "Error updating Student data: " . $conn->error;
    }
}





$conn->close();
?>



<!DOCTYPE html>
<html>

<head>
    <title>Student Panel</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <!-- Left Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-graduation-cap"></i> Student Panel</h2>
        </div>
        <ul class="nav">
            <li><a href="/Student Dashboard/Homepage/home.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="/Student Dashboard/Courses/courses.php"><i class="fas fa-book"></i> Courses</a></li>
            <li><a href="/Student Dashboard/Faculties/faculties.php"><i class="fas fa-users"></i> Faculties</a></li>
            <li><a href="/Student Dashboard/Marksheet/marksheetwithpdf.php"><i class="fas fa-file-text"></i> Marksheet</a></li>
            <li><a href="/Student Dashboard/Attendance Report/attendanceReport.php"><i class="fas fa-list-alt"></i> AttendanceReport</a></li>
            <li class="active"><a href="/Student Dashboard/Update Profile/updateProfile.php"><i class="fas fa-user"></i> Update Profile</a></li>
            <!-- <li><a href="/Student Dashboard/Notification/notification.php"><i class="fas fa-bell"></i> Notification</a></li> -->
            <li><a href="/Student Dashboard/Log Out/logout.php"><i class="fas fa-sign-out"></i> Log Out</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="header">
            <!-- <img src="../home/image/Imtiaz Chowdhury.jpg" alt="Profile Picture" class="profile-pic"> -->

            <div class="user-info">
                <div class="user-details">
                    <h3 style="color: rgb(0, 0, 0);">Welcome </h3><p><?php echo "$student_name" ?></p>

                </div>

            </div>

        </div>

        <div class="body">
            <h2 style="color: rgb(246, 105, 40);">Edit Profile & Credentials</h2>

            <!-- Form for updating profile -->
            <form id="myForm" action="updateProfile.php" method="post">
                <div>
                    <input type="text" hidden name="student_id" value="<?php echo "$student_id"; ?>">
                </div>
                <div>
                    <label for="teacher_name">Student Name:</label>
                    <input type="text" id="firstName" name="student_name" value="<?php echo "$student_name"; ?>">
                </div>
                <div>
                    <label for="email">Email ID:</label>
                    <input type="email" id="email" value="<?php echo "$email_id"; ?>" name="email">
                </div>
                <div>
                    <label for="contact">Contact:</label>
                    <input type="tel" id="phone" value="<?php echo "$contact"; ?>" name="contact">
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="text" id="password" value="<?php echo "$password"; ?>" name="password">
                </div>
                <div>
                    <label for="dept_name">Department Name:</label>
                    <input type="text" id="address" value="<?php echo "$dept_name"; ?>" name="dept_name">
                </div>
                <div>
                    <input type="submit" value="Submit" class="btn1">
                    <!-- <button type="submit" class="btn1">Submit</button> -->
                    <button type="button" onclick="cancelForm()" class="btn2">Cancel</button>
                </div>
            </form>

        </div>
    </div>

    <!-- <script src="script.js"></script> -->
</body>

</html>