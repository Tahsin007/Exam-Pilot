<?php
session_start();
if (!isset($_SESSION["student_id"])) {
    header("Location: http://localhost:3000/Login/login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam pilot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_id = $_SESSION["student_id"];
$sql = "SELECT * FROM students WHERE student_id = '$student_id' ";
$result = $conn->query($sql);
$student_dept_name = '';

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $student_dept_name = $row["dept_name"];
} else {
    echo "Student is not found";
}

$sql_courses = "SELECT * FROM courses WHERE department = '$student_dept_name' ";
// $sql_courses = "SELECT * FROM courses";

$result2 = $conn->query($sql_courses);

?>


<!DOCTYPE html>
<html>

<head>
    <title>Student Panel</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <!-- <link rel="stylesheet" type="text/css" href="styles2.css"> -->
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
            <li class="active"><a href="/Student Dashboard/Courses/courses.php"><i class="fas fa-book"></i> Courses</a></li>
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
                    <h1 style="color: rgb(250, 250, 250);">Courses</h1>

                </div>

            </div>

        </div>

        <div class="body">
            <div class="table-section">
                <table id="courseTable">
                    <thead>
                        <tr>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Semester</th>
                            <th>Dept Name</th>
                            <th>Course Credit</th>
                            <th>1st Examiner</th>
                            <th>2nd Examiner</th>
                            <th>3rd Examiner</th>
                            <!-- <th>Actions</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($result2) && $result2->num_rows > 0) {
                            while ($row = $result2->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td style='text-align: center;'>" . $row["course_code"] . "</td>";
                                echo "<td style='text-align: center;'>" . $row["course_name"] . "</td>";
                                echo "<td style='text-align: center;'>" . $row["semester"] . "</td>";
                                echo "<td style='text-align: center;'>" . $row["department"] . "</td>";
                                echo "<td style='text-align: center;'>" . $row["totall_credit"] . "</td>";

                                // Fetch the teacher names based on examiner IDs
                                $firstExaminerId = $row["1st_examiner_id"];
                                $secondExaminerId = $row["2nd_examiner_id"];
                                $thirdExaminerId = $row["3rd_examiner_id"];

                                $firstExaminerName = getFacultyName($firstExaminerId, $conn);
                                $secondExaminerName = getFacultyName($secondExaminerId, $conn);
                                $thirdExaminerName = getFacultyName($thirdExaminerId, $conn);

                                echo "<td style='text-align: center;'>" . $firstExaminerName . "</td>";
                                echo "<td style='text-align: center;'>" . $secondExaminerName . "</td>";
                                echo "<td style='text-align: center;'>" . $thirdExaminerName . "</td>";

                                // $courseCode = $row["course_code"];
                                // echo "<td style='text-align: center;'><a href='update_course.php?course_code=$courseCode'>Edit</a> | <a href='deleter_course.php?course_code=$courseCode' onclick='return confirm(\"Are you sure you want to delete this Course record?\")'>Delete</a></td>";

                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No records found</td></tr>";
                        }
                        function getFacultyName($facultyId, $conn)
                        {
                            $sql = "SELECT teacher_name FROM faculties WHERE teacher_id = '$facultyId'";
                            $result = $conn->query($sql);

                            if ($result->num_rows == 1) {
                                $row = $result->fetch_assoc();
                                return $row["teacher_name"];
                            } else {
                                return "N/A"; // Return a default value if faculty not found
                            }
                        }

                        $conn->close();

                        ?>
                    </tbody>
                </table>
            </div>



        </div>
    </div>

    <!-- <script src="script.js"></script> -->
</body>

</html>