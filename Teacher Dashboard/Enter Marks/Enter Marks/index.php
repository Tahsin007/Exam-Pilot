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

$sql = "SELECT * FROM student_marks WHERE teacher_id='$teacher_id'";
$result = $conn->query($sql);

$sql2 = "SELECT * FROM faculties as f JOIN courses as c ON (f.teacher_id = c.1st_examiner_id || f.teacher_id = c.2nd_examiner_id ||f.teacher_id = c.3rd_examiner_id) WHERE f.teacher_id = $teacher_id";

// $sql3 = "SELECT * FROM faculties WHERE teacher_id = '$teacher_id' ";
$result2 = $conn->query($sql2);
// $result3 = $conn->query($sql3);

// $courseCode='';
if (isset($result2) && $result2->num_rows > 0) {
  while ($row2 = $result2->fetch_assoc()) {
    $courseCode[] = $row2;
  }
} else {
  echo "<tr><td colspan='7'>No records found</td></tr>";
  header("Location: http://localhost:3000/Login/login.php");
  exit();
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Marks</title>
  <link rel="stylesheet" href="style.css">
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
        <li class="active"><a href="/Teacher Dashboard/Enter Marks/Enter Marks/index.php"><i class="fas fa-edit"></i> Enter Marks</a></li>
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
      <div class="section-title">Student Marks</div>
      <div class="form-section">
        <form action="db.php" id="form" method="post">
          <div class="form-row">
            <div class="form-field">
              <label for="courseCodeInput">Select Course</label>
              <!-- <input type="text" id="courseCodeInput" name="courseCode" required> -->
              <select class="form-control" id="courseCodeInput" name="courseCode">
                <?php foreach ($courseCode as $course_code) { ?>
                  <option value="<?php echo $course_code["course_code"]; ?>"><?php echo $course_code["course_code"] ?> <?php echo $course_code["course_name"]; ?></option>
                <?php } ?>
              </select>
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
            <input type="text" name="teacher_id" value="<?php echo "$teacher_id"; ?>" hidden>
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
              <!-- <th>Actions</th> -->
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

    document.addEventListener("DOMContentLoaded", function() {
      const form = document.querySelector("form");
      const ct1MarksInput = document.getElementById("ct1MarksInput");
      const ct2MarksInput = document.getElementById("ct2MarksInput");
      const ct3MarksInput = document.getElementById("ct3MarksInput");
      const attendanceMarksInput = document.getElementById("attendanceMarksInput");
      const finalMarksInput = document.getElementById("finalMarksInput");

      form.addEventListener("submit", function(event) {
        let isValid = true;

        // Validate CT1, CT2, and CT3 marks
        if (
          Number(ct1MarksInput.value) > 25 ||
          Number(ct2MarksInput.value) > 25 ||
          Number(ct3MarksInput.value) > 25
        ) {
          alert("CT1, CT2, and CT3 marks should be less than or equal to 25.");
          isValid = false;
        }

        // Validate attendance marks
        if (Number(attendanceMarksInput.value) > 5) {
          alert("Attendance marks should be less than or equal to 5.");
          isValid = false;
        }

        // Validate final marks
        if (Number(finalMarksInput.value) > 70) {
          alert("Final marks should be less than or equal to 70.");
          isValid = false;
        }

        if (!isValid) {
          event.preventDefault(); // Prevent form submission if validation fails
        }
      });
    });
  </script>

  <!-- <script src="script.js"></script> -->
</body>

</html>