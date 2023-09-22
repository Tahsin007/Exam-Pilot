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
$sql = "SELECT * FROM faculties as f JOIN courses as c ON (f.teacher_id = c.1st_examiner_id ||  f.teacher_id = c.2nd_examiner_id ||f.teacher_id = c.3rd_examiner_id) WHERE f.teacher_id = '$teacher_id' ";
$result = $conn->query($sql);


?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Assigned Subject</title>
  <link rel="stylesheet" href="styles2.css">
  <link rel="stylesheet" href="styles.css">
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
        <li class="active"><a href="/Teacher Dashboard/Assigned Subject/Assigned Subjects/index.php"><i class="fas fa-book"></i> Assigned Subjects</a>
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
      <div class="section-title">Assigned Subject</div>



      <div class="table-section">
        <table id="marksTable">
          <thead>
            <tr>
              <th>Session</th>
              <th>Dept Name</th>
              <th>Course Code</th>
              <th>Course Name</th>
              <th>Examiner</th>
              <th>Semester</th>
              <th>Total Credit</th>
              <!-- <th>CGPA</th> -->
            </tr>
          </thead>
          <tbody id="marksTableBody">
            <?php
            if (isset($result) && $result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $str = "";
                if ($teacher_id == $row["1st_examiner_id"]) {
                  $str = "1st Examiner";
                } else if ($teacher_id == $row["2nd_examiner_id"]) {
                  $str = "2nd Examiner";
                } else {
                  $str = "3rd Examiner";
                }
                echo "<tr>";
                echo "<td>" . $row["session"] . "</td>";
                echo "<td>" . $row["dept_name"] . "</td>";
                echo "<td>" . $row["course_code"] . "</td>";
                echo "<td>" . $row["course_name"] . "</td>";
                echo "<td>" . $str . "</td>";
                echo "<td>" . $row["semester"] . "</td>";
                echo "<td>" . $row["totall_credit"] . "</td>";
                // echo "<td>" . $row["totall_marks"] . "</td>";
                // echo "<td>" . $row["grade"] . "</td>";


                // $teacherId = $row["totall_marks"];
                // echo "<td><a href='update_teacher.php?teacher_id=$teacherId'>Edit</a> | <a href='delete_teacher.php?teacher_id=$teacherId' onclick='return confirm(\"Are you sure you want to delete this student record?\")'>Delete</a></td>";

                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='7'>No records found</td></tr>";
              header("Location: http://localhost:3000/Login/login.php");
              exit();
            }
            $conn->close();
            ?>
          </tbody>
        </table>
        <!-- <div class="download-button">
          <button onclick="downloadTable()">Download</button>
        </div> -->
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