<?php
session_start();
if (!isset($_SESSION["student_id"])) {
    echo "Student ID is not set up.";
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
$sql3 = "SELECT * FROM students WHERE student_id = '$student_id' ";
$result3 = $conn->query($sql3);

if (isset($result3) && $result3->num_rows == 1) {
    $row3 = $result3->fetch_assoc();

    $id = $row3["student_id"];
    $name = $row3["student_name"];
    $email = $row3["email_id"];
    $contact = $row3["contact"];
    $dept_name = $row3["dept_name"];
    $semester = $row3["semester"];
    $password = $row3["password"];
} else {
    echo "Records not found";
    header("Location: http://localhost:3000/Login/login.php");

    exit();
}

// Get the unique course codes for the student
$sql_courses = "SELECT DISTINCT course_code FROM student_marks WHERE student_id = '$student_id'";
$result_courses = $conn->query($sql_courses);

function calculateGrade($marks)
{
    // Add your grading criteria here
    if ($marks >= 80) {
        return 'A+';
    } elseif ($marks >= 75) {
        return 'A';
    } elseif ($marks >= 70) {
        return 'A-';
    } elseif ($marks >= 65) {
        return 'B+';
    } elseif ($marks >= 60) {
        return 'B';
    } elseif ($marks >= 55) {
        return 'B-';
    } elseif ($marks >= 50) {
        return 'C+';
    } elseif ($marks >= 45) {
        return 'C';
    } elseif ($marks >= 40) {
        return 'C-';
    } else {
        return 'F';
    }
}

// $conn->close();
?>


<!DOCTYPE html>
<html>

<head>
    <title>Student Panel</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" type="text/css" href="styles2.css">

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
            <li class="active"><a href="/Student Dashboard/Marksheet/marksheet.php"><i class="fas fa-file-text"></i> Marksheet</a></li>
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
                    <h1 style="color: rgb(250, 250, 250);">Marksheet</h1>

                </div>

            </div>
            <button class="download-button">Download</button>
        </div>

        <div class="body2">
            <div class="StudentInfo">

                <div class="info-column">
                    <p><strong>Student ID: <?php echo $id; ?></strong> <span id="student-id"></span></p>

                    <p><strong>Department: <?php echo $dept_name; ?></strong> <span id="department"></span></p>

                    <p><strong>Email: <?php echo $email; ?> </strong> <span id="dob"></span></p>

                </div>
                <div class="info-column">

                    <p><strong>Student Name: <?php echo $name; ?></strong> <span id="student-name"></span></p>

                    <p><strong>Semester/Year: <?php echo $semester; ?></strong> <span id="semester"></span></p>

                    <p><strong>Contact : <?php echo $contact; ?></strong> <span id="gender"></span></p>
                </div>
            </div>
            <div class="table-section">
                <table id="courseTable">
                    <thead>
                        <tr>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Credit</th>
                            <th>CT Marks</th>
                            <th>Attendance Marks</th>
                            <th>Totall Marks</th>
                            <th>Grade</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        if ($result_courses->num_rows > 0) {
                            while ($row_courses = $result_courses->fetch_assoc()) {
                                $course_code = $row_courses["course_code"];

                                // Query to fetch marks for the given student and course
                                $sql = "SELECT * FROM student_marks WHERE student_id = '$student_id' AND course_code = '$course_code'";
                                $result = $conn->query($sql);

                                $sql4 = "SELECT sm.course_code, c.course_name, c.totall_credit, sm.totall_marks, sm.grade  
                                        FROM student_marks as sm 
                                        INNER JOIN courses as c ON sm.course_code = c.course_code
                                        WHERE c.course_code = '$course_code' ";

                                $result4 = $conn->query($sql4);

                                if (isset($result4) && $result4->num_rows > 0) {
                                    $row4 = $result4->fetch_assoc();

                                    $course_name = $row4["course_name"];
                                    $totall_credit = $row4["totall_credit"];
                                } else {
                                    echo "Records not found for fetching the course details";
                                }

                                // $result2 = $conn->query($sql2);

                                if ($result->num_rows > 0) {
                                    $teacher1_final_marks = 0;
                                    $teacher2_final_marks = 0;
                                    $teacher3_final_marks = 0;
                                    $final_marks_to_use = 0;
                                    $marks = [];
                                    $ct1Marks = 0;
                                    $ct2Marks = 0;
                                    $ct3Marks = 0;
                                    $attendanceMarks = 0;
                                    while ($row = $result->fetch_assoc()) {
                                        $teacher_id = $row['teacher_id'];
                                        if ($teacher_id == 1) {
                                            $ct1Marks = $row['ct1_marks'];
                                            $ct2Marks = $row['ct2_marks'];
                                            $ct3Marks = $row['ct3_marks'];
                                            $attendanceMarks = $row['attendance_marks'];
                                        }
                                        $marks[$teacher_id] = $row['final_marks'];
                                    }

                                    // Check if marks from teacher_id 1 and teacher_id 2 exist
                                    if (isset($marks[1]) && isset($marks[2])) {

                                        $teacher1_final_marks = $marks[1];
                                        $teacher2_final_marks = $marks[2];
                                        $teacher3_final_marks = (isset($marks[3])) ? $marks[3] : 0;

                                        // Calculate the difference between teacher_id 1 and teacher_id 2 final marks
                                        $difference = abs($teacher1_final_marks - $teacher2_final_marks);



                                        // Determine which teacher's final marks to consider
                                        if ($difference > 14) {
                                            $teacher1_diff = abs($teacher1_final_marks  - $teacher3_final_marks);
                                            $teacher2_diff = abs($teacher2_final_marks - $teacher3_final_marks);

                                            // Determine the closest teacher based on the absolute differences
                                            $closest_teacher_id = ($teacher1_diff < $teacher2_diff) ? 1 : 2;

                                            // Calculate the average of marks from teacher_id 3 and the closest teacher
                                            // $final_marks_to_use = ($teacher3_final_marks + $marks[$closest_teacher_id]['final_marks']) / 2;
                                            $final_marks_to_use = ($teacher3_final_marks + $marks[$closest_teacher_id]) / 2;
                                        } else {
                                            $final_marks_to_use = ($teacher1_final_marks + $teacher2_final_marks) / 2;
                                        }

                                        $marksArray = array($ct1Marks, $ct2Marks, $ct3Marks);
                                        rsort($marksArray);
                                        $bestMarks = array_slice($marksArray, 0, 2);
                                        $averageOfBestMarks = array_sum($bestMarks) / count($bestMarks);
                                        // Calculate the total marks by adding CT marks, attendance marks, and average final marks
                                        // $total_marks = $final_marks_to_use + $marks[1]['ct1_marks'] + $marks[1]['ct2_marks'] + $marks[1]['ct3_marks'] + $marks[1]['attendance_marks'];
                                        $total_marks = $final_marks_to_use + $averageOfBestMarks + $attendanceMarks;

                                        // Calculate the grade based on your grading criteria
                                        $grade = calculateGrade($total_marks);

                                        // Output the results for this course
                                        echo "<tr>";
                                        echo "<td style='text-align: center;'>" . $course_code . "</td>";
                                        echo "<td style='text-align: center;'>" . $course_name . "</td>";
                                        echo "<td style='text-align: center;'>" . $totall_credit . "</td>";
                                        echo "<td style='text-align: center;'>" . $averageOfBestMarks . "</td>";
                                        echo "<td style='text-align: center;'>" . $attendanceMarks . "</td>";
                                        echo "<td style='text-align: center;'>" . $total_marks . "</td>";

                                        echo "<td style='text-align: center;'>" . $grade . "</td>";

                                        echo "</tr>";
                                        // echo "Course Code: $course_code<br>";
                                        // echo "Calculated Marks: $total_marks<br>";
                                        // echo "Grade: $grade<br><br>";
                                    } else {
                                        echo "Marks from teacher_id 1 and 2 are required for course code $course_code.<br><br>";
                                    }
                                } else {
                                    echo "No marks found for student ID $student_id and course code $course_code.<br><br>";
                                }
                            }
                        } else {
                            echo "No courses found for student ID $student_id.<br>";
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