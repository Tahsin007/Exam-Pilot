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

$sql = "SELECT * FROM faculties as f JOIN courses as c ON f.teacher_name = c.teacher_asigned WHERE f.teacher_id = $teacher_id";
$sql2 = "SELECT COUNT(*) as course_count FROM faculties as f JOIN courses as c ON f.teacher_name = c.teacher_asigned WHERE f.teacher_id = $teacher_id";
$sql3 = "SELECT * FROM faculties WHERE teacher_id = $teacher_id";
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
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
  <div class="container">
    <div class="menu">
      <div class="menu-icon">
        <span><img src="./images/mobile menu.png" alt=""></span>
        <span></span>
        <span></span>
      </div>
      <ul class="menu-items">
        <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
        <li><i class="fa-solid fa-code-pull-request"></i> Pending Request</a></li>
        <li><a href="#"><i class="fa-sharp fa-solid fa-square-check"></i> Enter Marks</a></li>
        <li><a href="#"><i class="fa-solid fa-chalkboard-user"></i> Mark Attendance</a></li>
        <li><a href="#"><i class="fa-sharp fa-solid fa-file"></i>Attendance Report</a></li>
        <li><a href="/Teacher Dashboard/Assigned Subject/index.php"><i class="fa-solid fa-user-graduate"></i>Assigned Subjects</a></li>
        <li><a href="#"><i class="fa-sharp fa-solid fa-file"></i> Marksheet Report</a></li>
        <li><a href="#"><i class="fa-sharp fa-solid fa-bell"></i> Notification</a></li>
        <li><a href="#"><i class="fa-solid fa-user"></i> Update Profile</a></li>
        <li><a href="#"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a></li>
      </ul>
    </div>
    <div class="content">
      <div class="card-row">
        <div class="details">
          <h2> Welcome <?php echo $teacher_details['teacher_name']; ?></h2>
        </div>
      </div>

      <div class="card-row">
        <div class="card">
          <div class="card-content">
            <div class="card-icon">
              <img src="./images/students.png" alt="Icon 1">
            </div>
            <h2>Students Assigned</h2>
            <h3><?php echo "$students"; ?></h3>

          </div>
        </div>
        <div class="card">
          <div class="card-content">
            <div class="card-icon">
              <img src="./images/courses.png" alt="Icon 2">
            </div>
            <h2>Courses Assigned</h2>
            <h3><?php echo $row_courses['course_count']; ?></h3>

          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="script.js"></script>
</body>

</html>