<?php
session_start();
if (!isset($_SESSION["teacher_id"])) {
  header("Location: http://localhost:3000/Login/login.php"); // Redirect to the login page if not logged in
  exit();
}

// Retrieve admin details from your database based on the admin_id stored in the session
$teacher_id = $_SESSION["teacher_id"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam pilot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM faculties WHERE teacher_id = $teacher_id";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
  $row = $result->fetch_assoc();

  $teacher_name = $row["teacher_name"];
  $email_id = $row["email_id"];
  $contact = $row["contact"];
  $dept_name = $row["dept_name"];
  $password = $row["password"];
} else {
  header("Location: http://localhost:3000/Login/login.php");
  exit();
}
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="styles.css">

  <!-- <script src="script.js"></script> -->
</head>

<body>
  <div class="container">
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

        <li><a href="/Teacher Dashboard/Notification/notification.php"><i class="fas fa-bell"></i> Notifications</a></li>
        <li class="active"><a href="/Teacher Dashboard/Update Profile/Update Profile/index.php"><i class="fas fa-user"></i> Update Profile</a></li>
        <li><a href="/Teacher Dashboard/Log Out/logout.php"><i class="fas fa-sign-out"></i> Log Out</a></li>
      </ul>
    </div>
    <div class="content">
      <!-- Form section -->
      <h1>Edit Profile</h1>
      <form id="myForm" action="updateForm.php" method="post">
        <div>
          <input type="number" hidden name="teacher_id" value="<?php echo $teacher_id; ?>" required>
        </div>
        <div>
          <label for="teacher_name">Teacher Name:</label>
          <input type="text" id="firstName" name="teacher_name" value="<?php echo $teacher_name; ?>" required>
        </div>
        <div>
          <label for="email">Email ID:</label>
          <input type="email" id="email" value="<?php echo $email_id; ?>" name="email" required>
        </div>
        <div>
          <label for="contact">Contact:</label>
          <input type="tel" id="phone" value="<?php echo $contact; ?>" name="contact">
        </div>
        <div>
          <label for="password">Password:</label>
          <input type="text" id="password" value="<?php echo $password; ?>" name="password">
        </div>
        <div>
          <label for="dept_name">Department Name:</label>
          <input type="text" id="address" value="<?php echo $dept_name; ?>" name="dept_name">
        </div>
        <div>
          <input type="submit" value="Submit" class="btn1">
          <!-- <button type="submit" class="btn1">Submit</button> -->
          <button type="button" onclick="cancelForm()" class="btn2">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>