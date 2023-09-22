<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);



session_start();
if (!isset($_SESSION["teacher_id"])) {
    header("Location: http://localhost:3000/Login/login.php"); // Redirect to the login page if not logged in
    exit();
}

// Retrieve admin details from your database based on the admin_id stored in the session
// $controller_id = $_SESSION["controller_id"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam pilot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$teacher_id = $_SESSION["teacher_id"];

$sql3 = "SELECT * FROM faculties WHERE teacher_id='$teacher_id'";
$result3 = $conn->query($sql3);

if ($result3->num_rows > 0) {
    while ($row = $result3->fetch_assoc()) {
        $teacher_name = $row["teacher_name"];
    }
}

$encryptionKey = random_bytes(32);


function encryptFile($inputFile, $outputFile, $encryptionKey, $iv)
{
    $fileContent = file_get_contents($inputFile);
    $encryptedContent = openssl_encrypt($fileContent, 'aes-256-cbc', $encryptionKey, 0, $iv);

    file_put_contents($outputFile, $encryptedContent);
}

if (isset($_POST["submit"])) {
    // Retrieve form data
    $courseCode = $_POST["courseCode"];
    $courseName = $_POST["course"];
    $semester = $_POST["semester"];
    $deptName = $_POST["department"];
    $sentFrom = "Exam Controller"; // Static for Exam Controller
    // $teacherName= $teacher_name;
    // $recipientTeacher = $_POST["teacher"]; // Selected teacher

    // Generate a secret key (you can use a suitable method to generate it)
    // $secretKey = generateSecretKey();
    $iv = openssl_random_pseudo_bytes(16);

    $questionFileName = ''; // Initialize variables for file names
    // $questionPatternFileName = '';

    if (isset($_FILES["question"])) {
        $uploadDir = "./pdf/";

        $questionFileName = uniqid() . "_" . basename($_FILES["question"]["name"]);

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Check for and handle file upload errors
        if ($_FILES["question"]["error"] !== UPLOAD_ERR_OK) {
            echo "File upload failed with error code " . $_FILES["question"]["error"];
        } else {
            // Upload the files to the server
            if (move_uploaded_file($_FILES["question"]["tmp_name"], $uploadDir . $questionFileName)) {
                // Insert data into the requestFile table
                $encryptedFileName = uniqid() . "_encrypted_" . $questionFileName;
                $inputFile = $uploadDir . $questionFileName;
                $outputFile = $uploadDir . $encryptedFileName;

                // Encrypt the file using AES-256
                encryptFile($inputFile, $outputFile, $encryptionKey, $iv);
                $recepient_controller = 1;


                $sql = "INSERT INTO send_question_controller (course_code, course_name, semester, department_name, sender_teacher_name, recepient_controller_id, question_file_path,encrypted_file_path,secret_key,iv) 
                VALUES ('$courseCode', '$courseName', '$semester', '$deptName', '$teacher_name','$recepient_controller', '$questionFileName','$encryptedFileName', '$encryptionKey','$iv')";

                if ($conn->query($sql) === TRUE) {
                    echo "Question submitted successfully.";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "File move operation failed.";
            }
        }
    } else {
        echo "You didn't select the accurate file.";
    }

    $conn->close();
}


require_once 'fetchData.php';

$departments = fetchData("department");
// $semesters = fetchData("semester");
$courses = fetchData("courses");
$teachers = fetchData("faculties");

?>



<!DOCTYPE html>
<html>

<head>
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="./pdf/">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <!-- Left Sidebar -->
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
            <li><a href="/Teacher Dashboard/Marksheet Report/Marksheet Report/index.php"><i class="fas fa-file-signature"></i> Marksheet Report</a></li>
            <li class="active"><a href="/Teacher Dashboard/send question/index.php"><i class="fas fa-file-signature"></i> Send Question</a></li>

            <li><a href="/Exam Controller//send questions/send question/send questions/index.php"><i class="fas fa-file-signature"></i> Receive Questions</a></li>

            <li><a href="/Teacher Dashboard/Notification/notification.php"><i class="fas fa-bell"></i> Notifications</a></li>
            <li><a href="/Teacher Dashboard/Update Profile/Update Profile/index.php"><i class="fas fa-user"></i> Update Profile</a></li>
            <li><a href="/Teacher Dashboard/Log Out/logout.php"><i class="fas fa-sign-out"></i> Log Out</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="header">

            <div class="user-info">
                <div class="user-details">
                    <h1 style="color: rgb(250, 250, 250);">Send Question</h1>

                </div>

            </div>

        </div>

        <div class="body">

            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label" for="department">Select Department:</label>
                    <select class="form-control" id="department" name="department">

                        <?php foreach ($departments as $department) { ?>
                            <option value="<?php echo $department["dept_name"]; ?>"><?php echo $department["dept_name"]; ?></option>
                        <?php } ?>

                        <!-- Add more options here -->
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="semester">Select Semester:</label>
                    <input type="text" id="semester" class="form-control" name="semester">

                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="course">Select Course:</label>
                    <select class="form-control" id="course" name="course">

                        <?php foreach ($courses as $course) { ?>
                            <option value="<?php echo $course["course_name"]; ?>"><?php echo $course["course_name"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="courseCode">Course Code:</label>
                    <input type="text" class="form-control" id="courseCode" name="courseCode" placeholder="Please Enter Course Code">
                </div>
                <!-- <div class="form-group">
                    <label class="form-label" for="teacher">Select Superintendant:</label>
                    <select class="form-control" id="teacher" name="teacher">

                         <?php foreach ($teachers as $teacher) { ?>
                            <option value="<?php echo $teacher["teacher_id"]; ?>"><?php echo $teacher["teacher_name"]; ?></option>
                        <?php } ?>

                        <!- Add more options here -->
                <!-- </select>
                </div>   -->
                <div class="form-group">
                    <label class="form-label" for="question">Question:</label>
                    <input type="file" class="form-control file-input" id="question" name="question">
                </div>

                <div class="form-buttons">
                    <button type="submit" name="submit" class="btn btn-primary">Send Question</button>
                    <button type="button" id="cancelButton" class="btn btn-primary">Cancel</button>
                </div>
            </form>



        </div>
    </div>

    <!-- <script src="script.js"></script> -->
</body>

</html>