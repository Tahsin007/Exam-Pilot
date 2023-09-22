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
// $sql2 = "SELECT * from student_marks WHERE student_id='$student_id";

$sql2 = "SELECT attendance.ID,attendance.student_name,attendance.course_code,courses.course_name,attendance.status,attendance.date 
        FROM attendance INNER JOIN courses 
        ON courses.course_code=attendance.course_code 
        WHERE attendance.ID = '$student_id' ";

$result2 = $conn->query($sql2);

?>


<!DOCTYPE html>
<html>

<head>
    <title>Student Panel</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <!-- <link rel="stylesheet" type="text/css" href="styles2.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="styles3.css"> -->


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
            <li class="active"><a href="/Student Dashboard/Attendance Report/attendanceReport.php"><i class="fas fa-list-alt"></i> AttendanceReport</a></li>
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
                    <h1 style="color: rgb(250, 250, 250);">Attendance Report</h1>

                </div>

            </div>

        </div>

        <div class="body2">
            <div class="StudentInfo">

                <div class="info-column">
                    <p><strong>Student ID: </strong><?php echo $id; ?> <span id="student-id"></span></p>

                    <p><strong>Department: </strong><?php echo $dept_name; ?> <span id="department"></span></p>

                    <p><strong>Email: </strong> <?php echo $email; ?> <span id="dob"></span></p>

                </div>
                <div class="info-column">

                    <p><strong>Student Name: </strong><?php echo $name; ?> <span id="student-name"></span></p>

                    <p><strong>Semester/Year: </strong><?php echo $semester; ?> <span id="semester"></span></p>

                    <p><strong>Contact : </strong><?php echo $contact; ?> <span id="gender"></span></p>
                </div>
            </div>
            <div class="table-section">
                <table id="courseTable">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Status</th>
                            <th>Date</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($result2) && $result2->num_rows > 0) {
                            while ($row = $result2->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td style='text-align: center;'>" . $row["ID"] . "</td>";
                                echo "<td style='text-align: center;'>" . $row["student_name"] . "</td>";
                                echo "<td style='text-align: center;'>" . $row["course_code"] . "</td>";
                                echo "<td style='text-align: center;'>" . $row["course_name"] . "</td>";
                                echo "<td style='text-align: center;'>" . $row["status"] . "</td>";
                                echo "<td style='text-align: center;'>" . $row["date"] . "</td>";
                                // $courseCode = $row["course_code"];
                                // echo "<td style='text-align: center;'><a href='update_course.php?course_code=$courseCode'>Edit</a> | <a href='deleter_course.php?course_code=$courseCode' onclick='return confirm(\"Are you sure you want to delete this Course record?\")'>Delete</a></td>";

                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No records found</td></tr>";
                        }
                        $conn->close();

                        ?>
                    </tbody>
                </table>
            </div>

            <!-- <button class="download-button">Download</button> -->
        </div>
    </div>

    <!-- <script src="script.js"></script> -->
</body>

</html>