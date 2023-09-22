<?php
session_start();
if (!isset($_SESSION["teacher_id"])) {
    header("Location: http://localhost:3000/Login/login.php");
    exit();
}
// header("Content-Type: application/octet-stream");


$teacher_id = $_SESSION["teacher_id"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam pilot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM send_question WHERE recipient_teacher = '$teacher_id'";
$result = $conn->query($sql);

function decryptFile($inputFile, $outputFile, $decryptionKey, $iv)
{
    $fileContent = file_get_contents($inputFile);
    // if($fileContent!=true){
    //     echo "File Can't Read";
    // }
    $decryptedContent = openssl_decrypt($fileContent, 'aes-256-cbc', $decryptionKey, 0, $iv);

    file_put_contents($outputFile, $decryptedContent);
}

?>



<!DOCTYPE html>
<html>

<head>
    <title>Responsive Page</title>
    <link rel=" stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" type="text/css" href="styles2.css">
    <link rel="stylesheet" type="text/css" href="/Exam Controller/send questions/send question/send questions/pdf/">


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
                    <li class="active"><a href="/Teacher Dashboard/Pending Request/Pending Request/index1.php"><i class="fas fa-user-clock"></i> Pending Request</a>
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

                    <li><a href="/Teacher Dashboard/Notification/notification.php"><i class="fas fa-bell"></i> Notifications</a></li>
                    <li><a href="/Teacher Dashboard/Update Profile/Update Profile/index.php"><i class="fas fa-user"></i> Update Profile</a></li>
                    <li><a href="/Teacher Dashboard/Log Out/logout.php"><i class="fas fa-sign-out"></i> Log Out</a></li>
                </ul>
            </div>
            <div class="content">
                <!-- <a href="64f8f3b405a2d_student_marks.pdf" target="_blank">Click Question</a> -->
                <div class="section-title">Pending Request</div>
                <!-- <embed src="C:\Users\TANIM\Desktop\Upload Dir\ <?php echo $syllabusFilePath . ".pdf"; ?>" type="application/pdf" width="700" height="700> -->
                <?php if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {


                        $requestId = $row["question_number"];
                        $department = $row["department_name"];
                        $semester = $row["semester"];
                        $courseName = $row["course_name"];
                        $courseCode = $row["course_code"];
                        $questionFile = $row["question_file_path"];
                        $encryptedFilePath = $row["encrypted_file_path"];
                        $secretKey = $row["secret_key"];
                        $iv = $row["iv"];

                        $uploadDir = "/Exam Controller/send questions/send question/send questions/pdf/";


                        $inputFile = $uploadDir . $encryptedFilePath;
                        $questionFilepath = $uploadDir . $questionFile;
                        // $questionPatternFilePath = $uploadDir . $questionPatternFileName;
                        $decryptedFileName = "_decrypted_" . $questionFile;

                        $outputFile = $uploadDir . $decryptedFileName;
                        // $ciphertext = file_get_contents($inputFile);

                        decryptFile($inputFile, $outputFile, $secretKey, $iv);

                        echo '<div class="mainCard">';
                        echo '<div class="title">';
                        echo "<h3>You have received a request to set this paper.</h3>";
                        echo '</div>';
                        echo '<div class="para">';
                        echo "Subject Code: $courseCode <br>";
                        echo "Course Name: $courseName <br>";
                        echo "Semester: $semester <br>";
                        echo "Dept Name: $department <br>";
                        echo "Encrypted File: $inputFile <br>";
                        echo "Decrypted File: $outputFile <br>";

                        echo "Sent From: Exam Controller <br>";
                        echo '</div>';
                        echo '<div class="btn">';
                        // echo '<button class="btn1" onclick="showFile(\'syllabusFrame\', \'' . $syllabusFilePath . '\')">Show Syllabus</button>';
                        echo "<button class='btn1' onclick='showFile(\"questionFrame\", \"$outputFile\")'>Show Question</button>";
                        echo "<iframe id='questionFrame' src='' width='100%' height='500px' style='display:none;'></iframe>";
                        // echo '<button class="btn2" onclick="showFile(\'questionPatternFrame\', \'' . $questionPatternFilePath . '\')">Show Question Pattern</button>';
                        // echo "<button class='btn2' onclick='showFile(\"questionPatternFrame\", \"$questionPatternFilePath\")'>Show Question Pattern</button>";
                        // echo "<iframe id='questionPatternFrame' src='' style='display:none;'></iframe>";
                        // echo '<button class="acceptBtn" onclick="acceptRequest(' . $requestId . ')">Accept</button>';
                        // echo '<button class="rejectBtn" onclick="rejectRequest(' . $requestId . ')">Reject</button>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "No requests found for this teacher.";
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