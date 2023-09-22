<?php
session_start();
if (!isset($_SESSION["teacher_id"])) {
    header("Location: http://localhost:3000/Login/login.php"); // Redirect to the login page if not logged in
    exit();
}

$teacher_id = $_SESSION["teacher_id"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam pilot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// $sql = "SELECT * FROM student_marks";
// $result = $conn->query($sql);

$sql2 = "SELECT * FROM faculties as f JOIN courses as c ON f.teacher_id = c.3rd_examiner_id WHERE f.teacher_id = '$teacher_id' ";

// $sql3 = "SELECT * FROM faculties WHERE teacher_id = '$teacher_id' ";
$result2 = $conn->query($sql2);
// $result3 = $conn->query($sql3);
$notificationMessage = "";

// $courseCode='';
// if (isset($result2) && $result2->num_rows > 0) {
//     while ($row2 = $result2->fetch_assoc()) {
//         $courseCode = $row2["course_code"];
//         // echo $courseCode;

//         $sql3 = "SELECT DISTINCT student_id FROM student_marks WHERE course_code ='$courseCode'";
//         $result2 = $conn->query($sql3);

//         if ($result2->num_rows > 0) {
//             $studentsData = array();

//             while ($row = $result2->fetch_assoc()) {
//                 $student_id = $row['student_id'];
//                 // echo $student_id;

//                 $sql4 = "SELECT sm.course_code,c.1st_examiner_id, c.2nd_examiner_id, c.3rd_examiner_id, c.course_name, c.totall_credit, sm.totall_marks, sm.grade  
//                 FROM student_marks as sm 
//                 INNER JOIN courses as c ON sm.course_code = c.course_code
//                 WHERE c.course_code = '$courseCode' ";

//                 $result4 = $conn->query($sql4);

//                 if (isset($result4) && $result4->num_rows > 0) {
//                     $row4 = $result4->fetch_assoc();
//                     $course_name = $row4["course_name"];
//                     $totall_credit = $row4["totall_credit"];
//                     $first_examiner_id = $row4["1st_examiner_id"];
//                     $second_examiner_id = $row4["2nd_examiner_id"];
//                     $third_examiner_id = $row4["3rd_examiner_id"];
//                     // echo $course_name;
//                 } else {
//                     echo "Records not found for fetching the course details";
//                 }

//                 $sql5 = "SELECT * FROM student_marks WHERE student_id='$student_id'";

//                 $result5 = $conn->query($sql5);
//                 if ($result5->num_rows > 0) {
//                     while ($row5 = $result5->fetch_assoc()) {
//                         $finalMarks = $row5["final_marks"];
//                         $teacher_id = $row5["teacher_id"];
//                         echo "$finalMarks";
//                         $marks[$teacher_id] = $row5['final_marks'];
//                     }

//                     // Check if marks from teacher_id 1 and teacher_id 2 exist
//                     if (isset($marks[$first_examiner_id]) && isset($marks[$second_examiner_id])) {

//                         $teacher1_final_marks = $marks[$first_examiner_id];
//                         $teacher2_final_marks = $marks[$second_examiner_id];
//                         // $teacher3_final_marks = (isset($marks[$third_examiner_id])) ? $marks[$third_examiner_id] : 0;

//                         // Calculate the difference between teacher_id 1 and teacher_id 2 final marks
//                         $difference = abs($teacher1_final_marks - $teacher2_final_marks);



//                         // Determine which teacher's final marks to consider
//                         if ($difference > 14) {
//                             echo "You need to give marks as a third examiner to " . $student_id . " on " . $courseCode;
//                         } else {
//                         }
//                     } else {
//                         echo "No records found";
//                     }
//                 }
//             }
//         }
//     }
// } else {
//     echo "<tr><td colspan='7'>No records found</td></tr>";
//     // header("Location: http://localhost:3000/Login/login.php");
//     // exit();
// }



?>


<!DOCTYPE html>
<html>

<head>
    <title>Responsive Page</title>
    <link rel=" stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" type="text/css" href="styles2.css">
    <link rel="stylesheet" type="text/css" href="/Exam Controller/Send Request/pdf/">


</head>

<body>
    <div class="container">
        <div class="menu">
            <div class="sidebar">
                <div class="sidebar-header">
                    <h2><i class="fas fa-graduation-cap"></i> Teacher Panel</h2>
                </div>
                <ul class="nav">
                    <li><a href="/Teacher Dashboard/Home/Home/index.php"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="/Teacher Dashboard/Pending Request/Pending Request/index1.php"><i class="fas fa-user-clock"></i> Pending Request</a>
                    </li>
                    <!-- <li><a href=""><i class="fas fa-question-circle"></i> Send Question</a> -->
                    </li>
                    <li><a href="/Teacher Dashboard/Enter Marks/Enter Marks/index.php"><i class="fas fa-edit"></i> Enter Marks</a></li>
                    <li><a href="/Teacher Dashboard/Mark Attendance/Mark Attendance//index.php"><i class="fas fa-clipboard-list"></i> Mark
                            Attendance</a></li>
                    <li><a href="/Teacher Dashboard/Attendance Report/Attendance Report/index.php"><i class="fas fa-file-alt"></i> Attendance
                            Report</a></li>
                    <li><a href="/Teacher Dashboard/Assigned Subject/Assigned Subjects/index.php"><i class="fas fa-book"></i> Assigned Subjects</a>
                    </li>
                    <li><a href="/Teacher Dashboard/Marksheet Report/Marksheet Report/index.php"><i class="fas fa-file-signature"></i> Marksheet
                            Report</a></li>
                    <li><a href="/Teacher Dashboard/send question/index.php"><i class="fas fa-file-signature"></i> Send Question</a></li>

                    <li><a href="/Exam Controller//send questions/send question/send questions/index.php"><i class="fas fa-file-signature"></i> Receive Questions</a></li>

                    <li class="active"><a href="/Teacher Dashboard/Notification/notification.php"><i class="fas fa-bell"></i> Notifications</a></li>
                    <li><a href="/Teacher Dashboard/Update Profile/Update Profile/index.php"><i class="fas fa-user"></i> Update Profile</a></li>
                    <li><a href="/Teacher Dashboard/Log Out/logout.php"><i class="fas fa-sign-out"></i> Log Out</a></li>
                </ul>
            </div>
            <div class="content">
                <!-- <a href="64f8f3b405a2d_student_marks.pdf" target="_blank">Click Question</a> -->
                <div class="section-title">Notification</div>
                <!-- <embed src="C:\Users\TANIM\Desktop\Upload Dir\ <?php echo $syllabusFilePath . ".pdf"; ?>" type="application/pdf" width="700" height="700> -->
                <?php if (isset($result2) && $result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        $courseCode = $row2["course_code"];
                        // echo $courseCode;

                        $sql3 = "SELECT DISTINCT student_id FROM student_marks WHERE course_code ='$courseCode'";
                        $result2 = $conn->query($sql3);

                        if ($result2->num_rows > 0) {
                            $studentsData = array();

                            while ($row = $result2->fetch_assoc()) {
                                $student_id = $row['student_id'];
                                // echo $student_id;

                                $sql4 = "SELECT sm.course_code,c.1st_examiner_id, c.2nd_examiner_id, c.3rd_examiner_id, c.course_name, c.totall_credit, sm.totall_marks, sm.grade  
                FROM student_marks as sm 
                INNER JOIN courses as c ON sm.course_code = c.course_code
                WHERE c.course_code = '$courseCode' ";

                                $result4 = $conn->query($sql4);

                                if (isset($result4) && $result4->num_rows > 0) {
                                    $row4 = $result4->fetch_assoc();
                                    $course_name = $row4["course_name"];
                                    $totall_credit = $row4["totall_credit"];
                                    $first_examiner_id = $row4["1st_examiner_id"];
                                    $second_examiner_id = $row4["2nd_examiner_id"];
                                    $third_examiner_id = $row4["3rd_examiner_id"];
                                    // echo $course_name;
                                } else {
                                    echo "Records not found for fetching the course details";
                                }

                                $sql5 = "SELECT * FROM student_marks WHERE student_id='$student_id'";

                                $result5 = $conn->query($sql5);
                                if ($result5->num_rows > 0) {
                                    while ($row5 = $result5->fetch_assoc()) {
                                        $finalMarks = $row5["final_marks"];
                                        $teacher_id = $row5["teacher_id"];
                                        echo "$finalMarks";
                                        $marks[$teacher_id] = $row5['final_marks'];
                                    }

                                    // Check if marks from teacher_id 1 and teacher_id 2 exist
                                    if (isset($marks[$first_examiner_id]) && isset($marks[$second_examiner_id])) {

                                        $teacher1_final_marks = $marks[$first_examiner_id];
                                        $teacher2_final_marks = $marks[$second_examiner_id];
                                        // $teacher3_final_marks = (isset($marks[$third_examiner_id])) ? $marks[$third_examiner_id] : 0;

                                        // Calculate the difference between teacher_id 1 and teacher_id 2 final marks
                                        $difference = abs($teacher1_final_marks - $teacher2_final_marks);



                                        // Determine which teacher's final marks to consider
                                        if ($difference > 14) {
                                            echo '<div class="mainCard">';
                                            echo '<div class="title">';
                                            echo "<h3>You have received a request to give marks as Third Examiner.</h3>";
                                            echo '</div>';
                                            echo '<div class="para">';
                                            echo "Subject Code: $courseCode <br>";
                                            echo "Course Name: $course_name <br>";
                                            echo "Student ID: $student_id <br>";
                                            // echo "Dept Name: $department <br>";
                                            // echo "Sent From: Exam Controller <br>";
                                            echo '</div>';
                                            echo '<div class="btn">';
                                            //echo "<button class='btn1' onclick='/Teacher Dashboard/Enter Marks/Enter Marks/index.php'>Show Syllabus</button>";
                                            echo '<a class="btn1" href="/Teacher Dashboard/Enter Marks/Enter Marks/index.php">Give Marks</a>';
                                            // // echo "<button class='btn1' onclick='showFile(\"syllabusFrame\", \"$syllabusFilePath\")'>Show Syllabus</button>";
                                            // // echo "<iframe id='syllabusFrame' src='' width='100%' height='500px' style='display:none;'></iframe>";
                                            // // echo '<button class="btn2" onclick="showFile(\'questionPatternFrame\', \'' . $questionPatternFilePath . '\')">Show Question Pattern</button>';
                                            // echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            // echo "You need to give marks as a third examiner to " . $student_id . " on " . $courseCode;
                                        } else {
                                        }
                                    } else {
                                        echo "No records found";
                                    }
                                }
                            }
                        }
                    }
                } else {
                    echo "<tr><td colspan='7'>No records found</td></tr>";
                    // header("Location: http://localhost:3000/Login/login.php");
                    // exit();
                }
                $conn->close();
                ?>
            </div>
        </div>
        <script>
            function showFile(iframeId, filePath) {
                const iframe = document.getElementById(iframeId);
                iframe.src = filePath;
                // iframe.style.display = 'block';
            }
        </script>
        <!-- <script src="script.js"></script> -->
</body>

</html>