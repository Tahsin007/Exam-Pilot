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

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $deptName = $_POST["deptName"];
  $semester = $_POST["semester"];
  $courseCode = $_POST["courseCode"];
  $courseName = $_POST["courseName"];


  // Prepare and execute an SQL INSERT statement
  $sql = "SELECT DISTINCT m.student_id, s.student_name, s.dept_name, m.course_code, m.grade,m.totall_marks
            FROM students s
            INNER JOIN student_marks m ON s.student_id = m.student_id
            WHERE m.course_code = '$courseCode'";


  // $sql = "SELECT DISTINCT student_id, course_code,totall_marks,grade FROM student_marks WHERE course_code='$courseCode'";

  // Execute the SQL query
  $result = $conn->query($sql);
}

$sql3 = "SELECT * FROM courses WHERE 1st_examiner_id = '$teacher_id' ";

// $sql3 = "SELECT * FROM faculties WHERE teacher_id = '$teacher_id' ";
$result3 = $conn->query($sql3);
// $result3 = $conn->query($sql3);

// $courseCode='';
// $courseName = [];
if (isset($result3) && $result3->num_rows > 0) {
  while ($row3 = $result3->fetch_assoc()) {
    $courseCode2[] = $row3;
    $courseName = $row3["course_name"];
  }
} else {
  echo "<tr><td colspan='7'>No records found</td></tr>";
  header("Location: http://localhost:3000/Login/login.php");
  exit();
}

// Close the database connection

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Marksheet Report</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="styles2.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

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
        <li class="active"><a href="/Teacher Dashboard/Marksheet Report/Marksheet Report/index.php"><i class="fas fa-file-signature"></i> Marksheet
            Report</a></li>
        <li><a href="/Teacher Dashboard/send question/index.php"><i class="fas fa-file-signature"></i> Send Question</a></li>
        <li><a href="/Exam Controller//send questions/send question/send questions/index.php"><i class="fas fa-file-signature"></i> Receive Questions</a></li>

        <li><a href="/Teacher Dashboard/Notification/notification.php"><i class="fas fa-bell"></i> Notifications</a></li>
        <li><a href="/Teacher Dashboard/Update Profile/Update Profile/index.php"><i class="fas fa-user"></i> Update Profile</a></li>
        <li><a href="/Teacher Dashboard/Log Out/logout.php"><i class="fas fa-sign-out"></i> Log Out</a></li>
      </ul>
    </div>
    <div class="content">
      <div class="section-title">Marksheet Report</div>
      <div class="form-section">
        <form action="index.php" method="post">
          <div class="form-row">
            <div class="form-field">
              <label for="departmentName">Department Name :</label>
              <input type="text" id="courseCodeInput" name="deptName" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-field">
              <label for="selectSemester">Select Semester :</label>
              <select name="semester" id="semester">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="4">5</option>
                <option value="4">6</option>
                <option value="4">7</option>
                <option value="4">8</option>


              </select>
              <!-- <input type="text" id="studentIDInput" name="semester" required> -->
            </div>

          </div>

          <div class="form-row">
            <div class="form-field">
              <label for="courseCode">Course Code :</label>
              <!-- <input type="text" id="ct3MarksInput" name="courseCode" required> -->
              <select class="form-control" id="courseCode" name="courseCode">
                <?php foreach ($courseCode2 as $course_code) { ?>
                  <option value="<?php echo $course_code["course_code"]; ?>"><?php echo $course_code["course_code"] ?> <?php echo $course_code["course_name"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-field">
              <label for="courseName">Course Name :</label>
              <input type="text" id="ct3MarksInput" name="courseName">
            </div>
          </div>
          <div class="form-buttons">
            <input type="submit" class="submit-button" value="Fetch Details">
            <button class="cancel-button">Cancel</button>
          </div>

        </form>
      </div>

      <div class="table-section">
        <table id="marksTable">
          <thead>
            <tr>
              <th>Student ID</th>
              <th>Student Name</th>
              <th>Dept Name</th>
              <th>Course Name</th>
              <th>Course Code</th>
              <th>Total Grade</th>
              <!-- <th>CGPA</th> -->
            </tr>
          </thead>
          <tbody id="marksTableBody">
            <?php
            if (isset($result) && $result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["student_id"] . "</td>";
                echo "<td>" . $row["student_name"] . "</td>";
                echo "<td>" . $row["dept_name"] . "</td>";
                echo "<td>" . $courseName . "</td>";
                echo "<td>" . $row["course_code"] . "</td>";

                // echo "<td>" . $row["totall_marks"] . "</td>";
                echo "<td>" . $row["grade"] . "</td>";


                // $teacherId = $row["totall_marks"];
                // echo "<td><a href='update_teacher.php?teacher_id=$teacherId'>Edit</a> | <a href='delete_teacher.php?teacher_id=$teacherId' onclick='return confirm(\"Are you sure you want to delete this student record?\")'>Delete</a></td>";

                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='7'>No records found</td></tr>";
            }
            $conn->close();
            ?>
          </tbody>
        </table>
        <div>
          <button class="download-button" onclick="downloadTable()">Download</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    function downloadTable() {
      var table = document.getElementById("marksTable");
      var clonedTable = table.cloneNode(true);
      clonedTable.style.width = "100%";
      var div = document.createElement("div");
      div.appendChild(clonedTable);
      html2pdf().from(div).save("student_marks.pdf");
    }
  </script>

  <!-- <script src="script.js"></script> -->
</body>

</html>