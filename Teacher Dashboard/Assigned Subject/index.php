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
$result = $conn->query($sql);


?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Assigned Subject</title>
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
      <div class="section-title">Assigned Subject</div>
      
        
      
      <div class="table-section">
        <table id="marksTable">
          <thead>
            <tr>
              <th>Faculty ID</th>
              <th>Faculty Name</th>
              <th>Dept Name</th>
              <th>Course Name</th>
              <th>Semester</th>
              <th>Total Credit</th>
              <!-- <th>CGPA</th> -->
            </tr>
          </thead>
          <tbody id="marksTableBody">
            <?php
            if (isset($result) && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["teacher_id"] . "</td>";
                    echo "<td>" . $row["teacher_name"] . "</td>";
                    echo "<td>" . $row["dept_name"] . "</td>";
                    echo "<td>" . $row["course_name"] . "</td>";
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
