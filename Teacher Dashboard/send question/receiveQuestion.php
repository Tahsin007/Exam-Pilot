<?php
session_start();
if (!isset($_SESSION["controller_id"])) {
    header("Location: http://localhost:3000/Login/login.php");
    exit();
}
// header("Content-Type: application/octet-stream");


$controller_id = $_SESSION["controller_id"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam pilot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM send_question_controller WHERE recepient_controller_id = '$controller_id'";
$result = $conn->query($sql);

function decryptFile($inputFile, $outputFile, $decryptionKey, $iv)
{
    // $fileContent = file_get_contents($inputFile);
    // if($fileContent!=true){
    //     echo "File Can't Read";
    // }
    $filecontent = file_get_contents($inputFile);
    $decryptedContent = openssl_decrypt($filecontent, 'aes-256-cbc', $decryptionKey, 0, $iv);

    file_put_contents($outputFile, $decryptedContent);
}

?>



<!DOCTYPE html>
<html>

<head>
    <title>Receive Questions</title>
    <link rel=" stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" type="text/css" href="styles2.css">
    <link rel="stylesheet" type="text/css" href="/Exam Controller/send questions/send question/send questions/pdf/">


</head>

<body>
    <div class="container">
        <div class="menu">
            <div class="sidebar">
                <div class="sidebar-header">
                    <h2><i class="fas fa-graduation-cap"></i> Exam Controller</h2>
                </div>
                <ul class="nav">
                    <li><a href="/Exam Controller/home/home.php"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="/Exam Controller/Send Request/sendRequest.php"><i class="fas fa-envelope"></i> Send Request</a></li>
                    <li><a href="/Exam Controller/send questions/send question/send questions/sendQuestion.php"><i class="fas fa-question-circle"></i> Send Question</a>
                    <li class="active"><a href="/Teacher Dashboard/send question/receiveQuestion.php"><i class="fas fa-question-circle"></i> Receive Question</a></li>
                    <!-- <li><a href="/Exam Controller/Notification//notification.php"><i class="fas fa-bell"></i> Notification</a></li> -->
                    <!-- <li><a href="../Result Approval/resultApproval.html"><i class="fas fa-check-circle"></i> Result Approval</a> -->
                    <!-- </li> -->
                    <li><a href="/Exam Controller/Update Profile/updateProfile.php"><i class="fas fa-user"></i> Update Profile</a></li>
                    <li><a href="/Exam Controller/Log Out/logout.php"><i class="fas fa-sign-out"></i> Log Out</a></li>
                </ul>
            </div>
            <div class="content">
                <!-- <a href="64f8f3b405a2d_student_marks.pdf" target="_blank">Click Question</a> -->
                <div class="section-title">Received Questions</div>
                <!-- <embed src="C:\Users\TANIM\Desktop\Upload Dir\ <?php echo $syllabusFilePath . ".pdf"; ?>" type="application/pdf" width="700" height="700> -->
                <?php if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {


                        $teacher_name = $row["sender_teacher_name"];
                        $department = $row["department_name"];
                        $semester = $row["semester"];
                        $courseName = $row["course_name"];
                        $courseCode = $row["course_code"];
                        $questionFile = $row["question_file_path"];
                        $encryptedFilePath = $row["encrypted_file_path"];
                        $secretKey = $row["secret_key"];
                        $iv = $row["iv"];

                        $uploadDir = "./pdf/";


                        $inputFile = $uploadDir . $encryptedFilePath;
                        $questionFilepath = $uploadDir . $questionFile;
                        // $questionPatternFilePath = $uploadDir . $questionPatternFileName;
                        $decryptedFileName = "_decrypted_" . $questionFile;

                        $outputFile = $uploadDir . $decryptedFileName;
                        // $ciphertext = file_get_contents($inputFile);

                        decryptFile($inputFile, $outputFile, $secretKey, $iv);

                        echo '<div class="mainCard">';
                        echo '<div class="title">';
                        echo "<h3>You have received a question paper</h3>";
                        echo '</div>';
                        echo '<div class="para">';
                        echo "Subject Code: $courseCode <br>";
                        echo "Course Name: $courseName <br>";
                        echo "Semester: $semester <br>";
                        echo "Dept Name: $department <br>";
                        // echo "Exam Time : 10 AM <br>";
                        // echo "Exam Date : 20/09/2023 <br>";

                        // echo "Encrypted File: $inputFile <br>";
                        // echo "Decrypted File: $outputFile <br>";

                        echo "Sent From: $teacher_name <br>";

                        echo '</div>';
                        echo '<div class="btn">';
                        // echo '<button class="btn1" onclick="showFile(\'syllabusFrame\', \'' . $syllabusFilePath . '\')">Show Syllabus</button>';
                        echo "<button class='btn1' onclick='showFile(\"questionFrame\", \"$outputFile\")'>Show Question</button>";
                        echo "<iframe id='questionFrame' src='' width='100%' height='500px' style='display:none;'></iframe>";
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