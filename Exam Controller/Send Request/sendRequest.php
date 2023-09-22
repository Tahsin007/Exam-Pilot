<?php
session_start();
if (!isset($_SESSION["controller_id"])) {
    header("Location: http://localhost:3000/Login/login.php");
    exit();
}

$controller_id = $_SESSION["controller_id"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam pilot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



if (isset($_POST["submit"])) {
    $departmentId = $_POST["department"];
    $semesterId = $_POST["semester"];
    $courseId = $_POST["course"];
    $courseCode = $_POST["courseCode"];
    $teacherId = $_POST["teacher"];
    $deadline = $_POST["deadline"];

    $syllabusFileName = ''; // Initialize variables for file names
    $questionPatternFileName = '';

    if (isset($_FILES["syllabus"]) && isset($_FILES["questionPattern"])) {
        $uploadDir = "./pdf/";
        // $uploadDir = "C:/Users/TANIM/Desktop/Upload Dir/ ";
        // $uploadDir = "C:/xampp/htdocs/Spl 2/Teacher Dashboard/Pending Request/Pending Request/ ";

        $syllabusFileName = uniqid() . "_" . basename($_FILES["syllabus"]["name"]);
        $questionPatternFileName = uniqid() . "_" . basename($_FILES["questionPattern"]["name"]);

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if ($_FILES["syllabus"]["error"] !== UPLOAD_ERR_OK || $_FILES["questionPattern"]["error"] !== UPLOAD_ERR_OK) {
            echo "File upload failed with error code " . $_FILES["syllabus"]["error"] . " and " . $_FILES["questionPattern"]["error"];
        } else {
            if (move_uploaded_file($_FILES["syllabus"]["tmp_name"], $uploadDir . $syllabusFileName) && move_uploaded_file($_FILES["questionPattern"]["tmp_name"], $uploadDir . $questionPatternFileName)) {
                $sql = "INSERT INTO sendrequest (department, semester, course_name, course_code, teacher_id, sqyllabus, question_pattern, deadline)
                        VALUES ('$departmentId', '$semesterId', '$courseId', '$courseCode', '$teacherId', '$syllabusFileName', '$questionPatternFileName','$deadline')";

                if ($conn->query($sql) === TRUE) {
                    echo "Request submitted successfully.";
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
    <title>Exam Controller Panel</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <!-- <link rel="stylesheet" type="text/css" href="./pdf/"> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <!-- Left Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-graduation-cap"></i> Exam Controller Panel</h2>
        </div>
        <ul class="nav">
            <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
            <li class="active"><a href="/Exam Controller/Send Request/sendRequest.php"><i class="fas fa-envelope"></i> Send Request</a></li>
            <li><a href="/Exam Controller/send questions/send question/send questions/sendQuestion.php"><i class="fas fa-question-circle"></i> Send Question</a>
            </li>
            <li><a href="/Teacher Dashboard/send question/receiveQuestion.php"><i class="fas fa-question-circle"></i> Receive Question</a></li>

            <!-- <li><a href="/Exam Controller/Notification//notification.php"><i class="fas fa-bell"></i> Notification</a></li> -->
            <!-- <li><a href="../Result Approval/resultApproval.html"><i class="fas fa-check-circle"></i> Result Approval</a> -->
            <!-- </li> -->
            <li><a href="/Exam Controller/Update Profile/updateProfile.php"><i class="fas fa-user"></i> Update Profile</a></li>
            <li><a href="/Exam Controller/Log Out/logout.php"></i> Log Out</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="header">

            <div class="user-info">
                <div class="user-details">
                    <h1 style="color: rgb(250, 250, 250);">Send Request</h1>

                </div>

            </div>

        </div>

        <div class="body">
            <form action="sendRequest.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label" for="department">Select Department:</label>
                    <select class="form-control" id="department" name="department">
                        <!-- <option value="dept1">IIT</option>
                        
                        <option value="dept2">CSTE</option>
                        <option value="dept3">ICE</option> -->
                        <?php foreach ($departments as $department) { ?>
                            <option value="<?php echo $department["dept_name"]; ?>"><?php echo $department["dept_name"]; ?></option>
                        <?php } ?>

                        <!-- Add more options here -->
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="semester">Select Semester:</label>

                    <input type="text" id="semester" class="form-control" name="semester">
                </div>
                <div class="form-group">
                    <label class="form-label" for="course">Select Course:</label>
                    <select class="form-control" id="course" name="course">
                        <!-- <option value="course1">Introdiction to SOftware Engineering</option>
                        <option value="course2">OOP-I</option>
                        <option value="course3">Theory of Computing</option> -->
                        <?php foreach ($courses as $course) { ?>
                            <option value="<?php echo $course["course_name"]; ?>"><?php echo $course["course_name"]; ?></option>
                        <?php } ?>
                        <!-- Add more options here -->
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="courseCode">Course Code:</label>
                    <input type="text" class="form-control" id="courseCode" name="courseCode">
                </div>
                <div class="form-group">
                    <label class="form-label" for="teacher">Select Teacher:</label>
                    <select class="form-control" id="teacher" name="teacher">
                        <!-- <option value="teacher1">Falguni Roy</option>
                        <option value="teacher2">Eusha Kadir</option>
                        <option value="teacher3">Iftekharul Alam Ifat</option>
                        <option value="teacher4">Tasniya Ahmed</option> -->
                        <?php foreach ($teachers as $teacher) { ?>
                            <option value="<?php echo $teacher["teacher_id"]; ?>"><?php echo $teacher["teacher_name"]; ?></option>
                        <?php } ?>

                        <!-- Add more options here -->
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="syllabus">Syllabus:</label>
                    <input type="file" class="form-control file-input" id="syllabus" name="syllabus">
                </div>
                <div class="form-group">
                    <label class="form-label" for="questionPattern">Question Pattern:</label>
                    <input type="file" class="form-control file-input" id="questionPattern" name="questionPattern">
                </div>
                <div class="form-group">
                    <label class="form-label" for="deadline">Deadline:</label>
                    <input type="date" class="form-control " id="deadline" name="deadline">
                </div>

                <div class="form-buttons">
                    <!-- <button type="submit" class="btn btn-primary">Send Request</button> -->
                    <input type="submit" name="submit" class="btn btn-primary" value="Send Request">
                    <button type="button" id="cancelButton" class="btn btn-primary">Cancel</button>
                </div>
            </form>



        </div>
    </div>

    <!-- <script src="script.js"></script> -->
</body>

</html>