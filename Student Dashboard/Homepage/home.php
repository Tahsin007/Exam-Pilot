<?php
session_start();
if (!isset($_SESSION["student_id"])) {
    echo "student id is not setup";
    header("Location: http://localhost:3000/Login/login.php"); // Redirect to the login page if not logged in
    exit();
}

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

if (isset($result) && $result->num_rows == 1) {
    $row = $result->fetch_assoc();

    $id = $row["student_id"];
    $name = $row["student_name"];
    $email = $row["email_id"];
    $contact = $row["contact"];
    $dept_name = $row["dept_name"];
    $semester = $row["semester"];
    $password = $row["password"];
} else {
    echo "Records not found";
    header("Location: http://localhost:3000/Login/login.php");

    exit();
}

// $sql_students = "SELECT COUNT(*) as student_count FROM students";
//$sql_departments = "SELECT COUNT(*) as department_count FROM department WHERE ";
$sql_courses = "SELECT COUNT(*) as course_count FROM courses WHERE department = '$dept_name'";
// $sql2 = "SELECT COUNT(*) as course_count FROM students as f JOIN courses as c ON f.teacher_name = c.teacher_asigned WHERE f.teacher_id = $teacher_id";

// $sql_faculties = "SELECT COUNT(*) as faculty_count FROM faculties";

// // Execute the queries
// $result_students = $conn->query($sql_students);
// $result_departments = $conn->query($sql_departments);
$result_courses = $conn->query($sql_courses);
// $result_faculties = $conn->query($sql_faculties);

// // Fetch the counts from the query results
// $row_students = $result_students->fetch_assoc();
// $row_departments = $result_departments->fetch_assoc();
$row_courses = $result_courses->fetch_assoc();
// $row_faculties = $result_faculties->fetch_assoc();

// Close the database connection

?>


<!DOCTYPE html>
<html>

<head>
    <title>Student Panel</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <!-- Left Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-graduation-cap"></i> Student Panel</h2>
        </div>
        <ul class="nav">
            <li class="active"><a href="/Student Dashboard/Homepage/home.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="/Student Dashboard/Courses/courses.php"><i class="fas fa-book"></i> Courses</a></li>
            <li><a href="/Student Dashboard/Faculties/faculties.php"><i class="fas fa-users"></i> Faculties</a></li>
            <li><a href="/Student Dashboard/Marksheet/marksheetwithpdf.php"><i class="fas fa-file-text"></i> Marksheet</a></li>
            <li><a href="/Student Dashboard/Attendance Report/attendanceReport.php"><i class="fas fa-list-alt"></i> AttendanceReport</a></li>
            <li><a href="/Student Dashboard/Update Profile/updateProfile.php"><i class="fas fa-user"></i> Update Profile</a></li>
            <!-- <li><a href="/Student Dashboard/Notification/notification.php"><i class="fas fa-bell"></i> Notification</a></li> -->
            <li><a href="/Student Dashboard/Log Out/logout.php"><i class="fas fa-sign-out"></i> Log Out</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="header">

            <div class="user-info">
                <div class="user-details">
                    <p>Welcome to the NSTU Web site!!!</p>
                    <h3 style="color: rgb(255, 133, 51);"><?php echo $name; ?></h3>
                    <!-- <p>Last login: <span id="last-login">dd/mm/yyyy</span></p> -->
                </div>

            </div>
            <!-- <img src=".\image\Imtiaz Chowdhury.jpg" alt="Profile Picture" class="profile-pic"> -->
        </div>

        <div class="body">

            <div class="card-row">

                <div class="card">
                    <div class="card-content">
                        <div class="card-icon">
                            <img src=".\image\courses.png" alt="Icon 2">
                        </div>
                        <h2>Total Courses</h2>
                        <p id="total-courses-count"><?php echo $row_courses['course_count']; ?></p>

                    </div>
                </div>
            </div>
            <div class="card-row">
                <div class="card">
                    <div class="card-content">
                        <div class="card-icon">
                            <img src=".\image\students.png" alt="Icon 3">
                        </div>
                        <h2>Total Semesters</h2>
                        <p id="total-semester-count">8</p>

                    </div>
                </div>

            </div>

        </div>
    </div>
    <?php
    $conn->close();
    ?>

    <!-- <script src="script.js"></script> -->
</body>

</html>