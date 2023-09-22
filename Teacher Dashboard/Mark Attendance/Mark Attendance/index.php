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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $deptName = $_POST["deptName"];
  $semester = $_POST["semester"];
  $courseCode = $_POST["course_code"];
  $todayDate = $_POST["select_date"];

  $sql2 = "SELECT * FROM students WHERE dept_name = '$deptName' AND semester = '$semester' ";
  $result2 = $conn->query($sql2);
  if (!$result2) {
    die("Error executing the query: " . $conn->error); // Handle the query error
  }
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

require_once 'fetchData.php';

$departments = fetchData("department");
// $faculties = fetchData("faculties");


// Close the database connection

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mark Attendance</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="styles2.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        <li class="active"><a href="/Teacher Dashboard/Mark Attendance/Mark Attendance//index.php"><i class="fas fa-clipboard-list"></i> Mark
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
      <div class="section-title">Mark Attendance</div>
      <form action="index.php" method="post">
        <div class="form-section">
          <div class="form-row">
            <div class="form-field">
              <label for="courseCodeInput">Select Date:</label>
              <input type="date" name="select_date" id="date">
            </div>
          </div>
          <div class="form-row">
            <div class="form-field">
              <label for="studentIDInput">Dept Name:</label>
              <!-- <input type="text" name="deptName" id="deptName"> -->
              <select class="form-control" id="deptName" name="deptName">
                <?php foreach ($departments as $department) { ?>
                  <option value="<?php echo $department["dept_name"]; ?>"><?php echo $department["dept_name"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-field">
              <label for="ct3MarksInput">Semester:</label>
              <input type="number" name="semester" id="semester">
            </div>
          </div>
          <div class="form-row">
            <div class="form-field">
              <label for="ct3MarksInput">Course Code:</label>
              <!-- <input type="text" name="course_code"> -->
              <select class="form-control" id="course_code" name="course_code">
                <?php foreach ($courseCode2 as $course_code) { ?>
                  <option value="<?php echo $course_code["course_code"]; ?>"><?php echo $course_code["course_code"] ?> <?php echo $course_code["course_name"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="form-buttons">
          <input type="submit" name="fetchDetails" class="submit-button" value="Fetch Details">
          <input type="submit" name="submitDetails" class="submit-button" value="Submit">
        </div>
      </form>

      <div class="table-section">
        <table id="marksTable">
          <thead>
            <tr>
              <th>Student ID</th>
              <th>Student Name</th>
              <th>Course Code</th>
              <!-- <th>Course Name</th> -->
              <th>Dept name</th>
              <th>Semester</th>
              <th>Attendance</th>
            </tr>
          </thead>
          <tbody id="marksTableBody">
            <form id="attendanceForm" method="post" action="process_attendance.php">
              <?php

              // Loop through the retrieved records and display them in the table
              $attendanceStatus = "";
              if (isset($_POST["fetchDetails"])) {
                if (isset($result2) && $result2->num_rows > 0) {
                  while ($row = $result2->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["student_id"] . "</td>";
                    echo "<td>" . $row["student_name"] . "</td>";
                    echo "<td>" . $_POST["course_code"] . "</td>";
                    // echo "<td>" . $courseName . "</td>";
                    echo "<td>" . $row["dept_name"] . "</td>";
                    echo "<td>" . $row["semester"] . "</td>";

                    $studentId = $row["student_id"];
                    // echo "<td>";

                    echo "<td>";
                    // echo "<label><input type='radio' name='attendance[$studentId]' value='present' " . ($attendanceStatus === 'present' ? 'checked' : '') . "> Present</label> | ";
                    // echo "<label><input type='radio' name='attendance[$studentId]' value='absent' " . ($attendanceStatus === 'absent' ? 'checked' : '') . "> Absent</label>";
                    echo "<label><input type='radio' name='attendance[$studentId]' value='present'> Present</label> | ";
                    echo "<label><input type='radio' name='attendance[$studentId]' value='absent'> Absent</label>";
                    echo "</td>";

                    // echo "<td><a href='update_student.php?student_id=$studentId'>Edit</a> | <a href='deleteStudents.php?student_id=$studentId' onclick='return confirm(\"Are you sure you want to delete this student record?\")'>Delete</a></td>";

                    // echo "</tr>";

                    // Store the values in hidden fields within the form
                    echo "<input type='hidden' name='student_id[]' value='" . $row["student_id"] . "'>";
                    echo "<input type='hidden' name='student_name[]' value='" . $row["student_name"] . "'>";
                    echo "<input type='hidden' name='course_code[]' value='" . $_POST["course_code"] . "'>";
                    echo "<input type='hidden' name='dept_name[]' value='" . $row["dept_name"] . "'>";
                    echo "<input type='hidden' name='semester[]' value='" . $row["semester"] . "'>";
                    echo "<input type='hidden' name='attendance_hidden[$studentId]' value=''>";
                    echo "<input type='hidden' name='date[]' value='" . $todayDate . "'>";

                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='7'>No records found</td></tr>";
                }
              }

              // echo "<td><a href='update_student.php'>Submit</a></td>";
              $conn->close();
              ?>

              <input type="submit" name="submitAttendance" id="submitAttendance" value="Submit Attendance">
            </form>

          </tbody>
        </table>
        <!-- <div class="download-button">
        <button onclick="downloadTable()">Download</button>
      </div> -->
      </div>
    </div>
  </div>
  <script>
    // $(document).ready(function() {
    //   $('input[type=radio]').change(function() {
    //     var studentId = $(this).closest('tr').find('td:first').text();
    //     // var attendanceValue = $(this).closest('tr').find('td:last').text();
    //     var attendanceValue = $(this).val();

    //     $('input[name="attendance_hidden[' + studentId + ']"]').val(attendanceValue);
    //   });
    // });

    $(document).ready(function() {
      $('input[type=radio]').change(function() {
        var studentId = $(this).closest('tr').find('td:first').text();
        var attendanceValue = $(this).val();

        $('input[name="attendance_hidden[' + studentId + ']"]').val(attendanceValue);

        // Submit the form when a radio button is clicked
        // $('#attendanceForm').submit();
      });
    });
  </script>

  <!-- <script src="script.js"></script> -->
</body>

</html>