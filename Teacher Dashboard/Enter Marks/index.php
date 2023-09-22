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

$sql = "SELECT * FROM student_marks";
$result = $conn->query($sql);

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Marks</title>
  <link rel="stylesheet" href="styles.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

</head>
<body>
  <div class="container">
    <div class="menu">
      <div class="menu-icon">&#9776;</div>
      <ul class="menu-items">
        <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
        <li><i class="fa-solid fa-code-pull-request"></i> Pending Request</a></li>
        <li><a href="#"><i class="fa-sharp fa-solid fa-square-check"></i> Enter Marks</a></li>
        <li><a href="#"><i class="fa-solid fa-chalkboard-user"></i> Mark Attendance</a></li>
        <li><a href="#"><i class="fa-sharp fa-solid fa-file"></i>Attendance Report</a></li>
        <li><a href="#"><i class="fa-solid fa-user-graduate"></i>Assigned Subjects</a></li>
        <li><a href="#"><i class="fa-sharp fa-solid fa-file"></i> Marksheet Report</a></li>
        <li><a href="#"><i class="fa-sharp fa-solid fa-bell"></i> Notification</a></li>
        <li><a href="#"><i class="fa-solid fa-user"></i> Update Profile</a></li>
        <li><a href="#"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a></li>
      </ul>
    </div>
    <div class="content">
      <div class="section-title">Student Marks</div>
      <div class="form-section">
        <form action="db.php" method="post">
          <div class="form-row">
          <div class="form-field">
            <label for="courseCodeInput">Course Code</label>
            <input type="text" id="courseCodeInput" name="courseCode" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-field">
            <label for="studentIDInput">Student ID</label>
            <input type="text" id="studentIDInput" name="studentId" required>
          </div>
          <div class="form-field">
            <label for="ct1MarksInput">CT1 Marks</label>
            <input type="number" id="ct1MarksInput" name="ct1Marks" required>
          </div>
          <div class="form-field">
            <label for="ct2MarksInput">CT2 Marks</label>
            <input type="number" id="ct2MarksInput" name="ct2Marks" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-field">
            <label for="ct3MarksInput">CT3 Marks</label>
            <input type="number" id="ct3MarksInput" name="ct3Marks" required>
          </div>
          <div class="form-field">
            <label for="attendanceMarksInput">Attendance Marks</label>
            <input type="number" id="attendanceMarksInput" name="attendanceMarks" required>
          </div>
          <div class="form-field">
            <label for="finalMarksInput">Final Marks</label>
            <input type="number" id="finalMarksInput" name="finalMarks" required>
          </div>
          <input type="text" name="teacher_id" value="<?php echo"$teacher_id"; ?>" hidden>
        </div>
        <div class="form-buttons">
        <input type="submit" class="submit-button" value="Submit">
        <button class="cancel-button">Cancel</button>
      </div>

        </form>
      </div>
      
      <div class="table-section">
        <table id="marksTable">
          <thead>
            <tr>
              <th>Student ID</th>
              <th>Course Code</th>
              <th>CT1 Marks</th>
              <th>CT2 Marks</th>
              <th>CT3 Marks</th>
              <th>Attendance Marks</th>
              <th>Totall Marks</th>
              <th>Grade</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="marksTableBody">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["student_id"] . "</td>";
                    echo "<td>" . $row["course_code"] . "</td>";
                    echo "<td>" . $row["ct1_marks"] . "</td>";
                    echo "<td>" . $row["ct2_marks"] . "</td>";
                    echo "<td>" . $row["ct3_marks"] . "</td>";
                    echo "<td>" . $row["attendance_marks"] . "</td>";
                    echo "<td>" . $row["totall_marks"] . "</td>";
                    echo "<td>" . $row["grade"] . "</td>";
                    

                    // $teacherId = $row["totall_marks"];
                    // echo "<td><a href='update_teacher.php?teacher_id=$teacherId'>Edit</a> | <a href='delete_teacher.php?teacher_id=$teacherId' onclick='return confirm(\"Are you sure you want to delete this student record?\")'>Delete</a></td>";

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No records found</td></tr>";
            }
            ?>
          </tbody>
        </table>
        <div class="download-button">
        <button onclick="downloadTable()">Download</button>
      </div>
      </div>
    </div>
  </div>
  <script>
    function downloadTable(){
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
