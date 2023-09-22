<?php
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
    $sql = "SELECT s.student_id, s.student_name, s.dept_name, m.course_code, m.grade
            FROM students s
            INNER JOIN student_marks m ON s.student_id = m.student_id
            WHERE m.course_code = '$courseCode'";

    // Execute the SQL query
    $result = $conn->query($sql);
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

            </select>
            <!-- <input type="text" id="studentIDInput" name="semester" required> -->
          </div>
          
        </div>
        <div class="form-row">
          <div class="form-field">
            <label for="courseCode">Course Code :</label>
            <input type="text" id="ct3MarksInput" name="courseCode" required>
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
                    echo "<td>" . $row["grade"] . "</td>";
                    // echo "<td>" . $row["totall_marks"] . "</td>";
                    // echo "<td>" . $row["grade"] . "</td>";
                    

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
