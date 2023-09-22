<?php
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





// Close the database connection

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mark Attendance</title>
  <link rel="stylesheet" href="styles.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
              <input type="text" name="deptName" id="deptName">
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
              <input type="text" name="course_code">
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

              echo "<td><a href='update_student.php'>Submit</a></td>";
              $conn->close();
              ?>

              <input type="submit" name="submitAttendance" value="Submit Attendance">
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