<?php
session_start();
if (!isset($_SESSION["controller_id"])) {
    header("Location: http://localhost:3000/Login/login.php"); // Redirect to the login page if not logged in
    exit();
}

// Retrieve admin details from your database based on the admin_id stored in the session
$controller_id = $_SESSION["controller_id"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam pilot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM exam_controller WHERE Id = '$controller_id' ";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $controller_details = $result->fetch_assoc();

    $controller_name = $controller_details["name"];
    $controller_email = $controller_details["email"];
    $controller_password = $controller_details["password"];
    $controller_contact = $controller_details["contact"];
} else {
    header("Location: http://localhost:3000/Login/login.php");
    exit();
}

$sql_students = "SELECT COUNT(*) as student_count FROM students";
$sql_departments = "SELECT COUNT(*) as department_count FROM department";
$sql_courses = "SELECT COUNT(*) as course_count FROM courses";
$sql_faculties = "SELECT COUNT(*) as faculty_count FROM faculties";

// Execute the queries
$result_students = $conn->query($sql_students);
$result_departments = $conn->query($sql_departments);
$result_courses = $conn->query($sql_courses);
$result_faculties = $conn->query($sql_faculties);

// Fetch the counts from the query results
$row_students = $result_students->fetch_assoc();
$row_departments = $result_departments->fetch_assoc();
$row_courses = $result_courses->fetch_assoc();
$row_faculties = $result_faculties->fetch_assoc();

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html>

<head>
    <title>Exam Controller Panel</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <!-- Left Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-graduation-cap"></i> Exam Controller Panel</h2>
        </div>
        <ul class="nav">
            <li class="active"><a href="#"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="/Exam Controller/Send Request/sendRequest.php"><i class="fas fa-envelope"></i> Send Request</a></li>
            <li ><a href="/Exam Controller/send questions/send question/send questions/sendQuestion.php"><i class="fas fa-question-circle"></i> Send Question</a>
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
                    <h3 style="color: rgb(255, 133, 51);">Welcome <?php echo "$controller_name"; ?></h3>
                    <p>Last login: <span id="last-login">dd/mm/yyyy</span></p>
                </div>
            </div>
            <!-- <img src=".\image\Imtiaz Chowdhury.jpg" alt="Profile Picture" class="profile-pic"> -->
        </div>

        <div class="body">

            <div class="card-container">

                <div class="card-row">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-icon">
                                <img src="./images/students.png" alt="Icon 1">
                            </div>
                            <h2>Students</h2>
                            <p id="total-students-count"><?php echo $row_students['student_count']; ?></p>

                        </div>
                    </div>
                </div>
                <div class="card-row">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-icon">
                                <img src="./images/faculties.png" alt="Icon 2">
                            </div>
                            <h2>Faculties</h2>
                            <p id="total-faculties-count"><?php echo $row_faculties['faculty_count']; ?></p>

                        </div>
                    </div>
                </div>
                <div class="card-row">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-icon">
                                <img src="./images/courses.png" alt="Icon 3">
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
                                <img src="./images/Departments.png" alt="Icon 4">
                            </div>
                            <h2>Departments</h2>
                            <p id="total-departments-count"><?php echo $row_departments['department_count']; ?></p>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- <script src="script.js"></script> -->
</body>

</html>