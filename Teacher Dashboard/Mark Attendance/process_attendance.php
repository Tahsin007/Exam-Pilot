<?php
// Check if the "submitAttendance" button is clicked
if (isset($_POST["submitAttendance"])) {
  // Get the date for the attendance record (you can customize this as needed)
  $date = date("Y-m-d"); // Assuming a date format like YYYY-MM-DD

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "exam pilot";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

  // Retrieve data from the form submission
  $studentIds = $_POST["student_id"];
  $studentNames = $_POST["student_name"];
  $courseCodes = $_POST["course_code"];
  $deptNames = $_POST["dept_name"];
  $semesters = $_POST["semester"];
  $currDate = $_POST["date"];
  $attendanceStatuses = $_POST['attendance_hidden'];


  // Iterate through the data and insert records into the attendance database
  for ($i = 0; $i < count($studentIds); $i++) {
    // Sanitize the input data to prevent SQL injection (you can use prepared statements for better security)
    $studentId = $conn->real_escape_string($studentIds[$i]);
    $studentName = $conn->real_escape_string($studentNames[$i]);
    $courseCode = $conn->real_escape_string($courseCodes[$i]);
    $deptName = $conn->real_escape_string($deptNames[$i]);
    $semester = $conn->real_escape_string($semesters[$i]);
    $dateUpdate = $conn->real_escape_string($currDate[$i]);
    $attendanceStatus = $conn->real_escape_string($attendanceStatuses[$studentId]); // Corrected this line

    // Insert a new record into the attendance database with all the details
    $query = "INSERT INTO attendance (ID, date, status, student_name, course_code, dept_name, semester) 
              VALUES ('$studentId', '$dateUpdate', '$attendanceStatus', '$studentName', '$courseCode', '$deptName', '$semester')";

        if ($conn->query($query) !== TRUE) {
            echo "Error inserting record: " . $conn->error;
        } else {
            echo "Attendance data is inserted";
        }
  }
    

    // Close the attendance database connection
    $conn->close();

}
