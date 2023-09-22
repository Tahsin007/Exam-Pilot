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

$sql = "SELECT * FROM faculties as f JOIN courses as c ON (f.teacher_id = c.1st_examiner_id || f.teacher_id = c.2nd_examiner_id ||f.teacher_id = c.3rd_examiner_id) WHERE f.teacher_id = $teacher_id";
$sql2 = "SELECT COUNT(*) as course_count FROM faculties as f JOIN courses as c ON (f.teacher_id = c.1st_examiner_id || f.teacher_id = c.2nd_examiner_id ||f.teacher_id = c.3rd_examiner_id) WHERE f.teacher_id = $teacher_id";
//$sql2 = "SELECT * FROM faculties WHERE teacher_id = '$teacher_id'";

$sql3 = "SELECT * FROM faculties WHERE teacher_id = '$teacher_id' ";
$result = $conn->query($sql);
$result2 = $conn->query($sql2);
$result3 = $conn->query($sql3);


if (isset($result) && $result->num_rows > 0) {
  $students = 0;
  while ($row = $result->fetch_assoc()) {

    $students = $students + $row["totall_students"];
  }
} else {
  echo "<tr><td colspan='7'>No records found</td></tr>";
  header("Location: http://localhost:3000/Login/login.php");
  exit();
}

$row_courses = $result2->fetch_assoc();
$teacher_details = $result3->fetch_assoc();


$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
  <title>Responsive Page</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
  <link rel="stylesheet" type="text/css" href="style.css">


</head>

<body>
  <div class="container">
    <div class="sidebar">
      <div class="sidebar-header">
        <h2><i class="fas fa-graduation-cap"></i> Teacher Panel</h2>
      </div>
      <ul class="nav">
        <li class="active"><a href="/Teacher Dashboard/Home/Home/index.php"><i class="fas fa-home"></i> Home</a></li>
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

        <li><a href="/Teacher Dashboard/Notification/notification.php"><i class="fas fa-bell"></i> Notifications</a></li>
        <li><a href="/Teacher Dashboard/Update Profile/Update Profile/index.php"><i class="fas fa-user"></i> Update Profile</a></li>
        <li><a href="/Teacher Dashboard/Log Out/logout.php"><i class="fas fa-sign-out"></i> Log Out</a></li>
      </ul>
    </div>
    <div class="content">
      <div class="card-row">
        <div class="details">
          <h2 style="color: rgb(255, 133, 51);"> Welcome <?php echo $teacher_details['teacher_name']; ?></h2>
          <p>Last login: <span id="last-login">dd/mm/yyyy</span></p>
        </div>
      </div>

      <div class="card-row">
        <div class="card">
          <div class="card-content">
            <div class="card-icon">
              <img src="./image/students.png" alt="Icon 1">
            </div>
            <h3>Students Assigned</h2>
              <h3><?php echo "$students"; ?></h3>

          </div>
        </div>
        <div class="card">
          <div class="card-content">
            <div class="card-icon">
              <img src="./image/courses.png" alt="Icon 2">
            </div>
            <h3>Courses Assigned</h2>
              <h3><?php echo $row_courses['course_count']; ?></h3>

          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="script.js"></script>
</body>

</html>