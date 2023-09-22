 <?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "exam pilot";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM department";
  $result = $conn->query($sql);



  if (isset($_GET["dept_code"])) {
    $dept_code = $_GET["dept_code"];

    $sql = "DELETE FROM department WHERE dept_code = '$dept_code'";

    if ($conn->query($sql) === TRUE) {
        echo "Department record deleted successfully.";
    } else {
        echo "Error deleting department record: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $deptCode = $_POST["deptCode"];
    $deptName = $_POST["deptName"];
    $courses = $_POST["courses"];
    $semester = $_POST["semester"];
    $students = $_POST["students"];
    $credit = $_POST["credit"];

    $sql = "INSERT INTO department (dept_code, dept_name, totall_courses, totall_semester, totall_student, totall_credit)
            VALUES ('$deptCode', '$deptName', '$courses', '$semester', '$students', '$credit')";

    $conn->query($sql);
}

$conn->close();

?>

 <!DOCTYPE html>
 <html>

 <head>
   <title>Department</title>
   <link rel="stylesheet" type="text/css" href="styles.css">
   <link rel="stylesheet" href="styles2.css">
 </head>

 <body>
   <div class="none">
     <div class="sidebar">
       <div class="sidebar-header">
         <h2><i class="fas fa-graduation-cap"></i> Admin Panel</h2>
       </div>
       <ul class="nav">
         <li><a href="/Admin Dashboard/home//home.php"><i class="fas fa-home"></i> Home</a></li>
         <li><a href="/Admin Dashboard/Students/index.php"><i class="fas fa-users"></i> Students</a></li>
         <li><a href="/Admin Dashboard/Faculties/index.php"><i class="fas fa-user-tie"></i> Faculties</a></li>
         <li><a href="/Admin Dashboard/courses/index2.php"><i class="fas fa-book"></i> Courses</a></li>
         <li class="active"><a href="/Admin Dashboard/Departments//index.php"><i class="fas fa-building"></i> Departments</a></li>
         <!-- <li><a href="/Admin Dashboard//Notification//notification.php"><i class="fas fa-bell"></i> Notification</a></li> -->
         <!-- <li><a href="../Update Profile/updateProfile.html"><i class="fas fa-user"></i> Update Profile</a></li> -->
         <li><a href="/Admin Dashboard//Log Out/logout.php"><i class="fas fa-sign-out"></i> Log Out</a></li>
       </ul>
     </div>
     <div class="content">
       <div class="title-section">
         <h1>Departments</h1>
       </div>
       <div class="form-section">
         <form method="post" action="" id="myForm">
           <div class="form-row">
             <div class="form-field">
               <label for="studentId">Dept Code:</label>
               <input type="text" name="deptCode" required>
             </div>
             <div class="form-field">
               <label for="studentName">Dept Name:</label>
               <input type="text" name="deptName" required>
             </div>
             <div class="form-field">
               <label for="totallCourses">Total Courses:</label>
               <input type="number" name="courses" required>
             </div>
           </div>
           <div class="form-row">
             <div class="form-field">
               <label for="contact">Total Semester:</label>
               <input type="number" name="semester" required>
             </div>
             <div class="form-field">
               <label for="deptName">Total Students:</label>
               <input type="number" name="students" required>
             </div>
             <div class="form-field">
               <label for="password">Total Credit:</label>
               <input type="number" name="credit" required>
             </div>
           </div>
           <div class="form-actions">
             <input type="submit" value="Submit" class="btn1">
             <!-- <button type="submit" class="btn1">Submit</button> -->
             <button type="button" onclick="cancelForm()" class="btn2">Cancel</button>
           </div>
         </form>
       </div>
       <div class="table-section">
         <table id="studentsTable">
           <thead>
             <tr>
               <th>Dept Code</th>
               <th>Dept Name</th>
               <th>Total Courses</th>
               <th>Total Semester</th>
               <th>Total Students</th>
               <th>Total Credit</th>
               <th>Actions</th>
             </tr>
           </thead>
           <tbody>
             <?php
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td style='text-align: center;'>" . $row["dept_code"] . "</td>";
                  echo "<td style='text-align: center;'>" . $row["dept_name"] . "</td>";
                  echo "<td style='text-align: center;'>" . $row["totall_courses"] . "</td>";
                  echo "<td style='text-align: center;'>" . $row["totall_semester"] . "</td>";
                  echo "<td style='text-align: center;'>" . $row["totall_student"] . "</td>";
                  echo "<td style='text-align: center;'>" . $row["totall_credit"] . "</td>";
                  $deptCode = $row["dept_code"];
                  echo "<td style='text-align: center;'><a href='update_dept.php?dept_code=$deptCode'>Edit</a> | <a href='index.php?dept_code=$deptCode' onclick='return confirm(\"Are you sure you want to delete this department record?\")'>Delete</a></td>";

                  echo "</tr>";
                }
              } else {
                echo "<tr><td colspan='7'>No records found</td></tr>";
              }
              ?>
           </tbody>
         </table>
       </div>
     </div>
   </div>

    <div class="popup" id="popup">
        <div class="popup-content">
            <span class="close" id="close">&times;</span>
            <h2>Department Info Inserted Successfully</h2>
            <p>Department Info has been inserted into the database.</p>
        </div>
    </div>
    <script>
        var popup = document.getElementById("popup");
        var close = document.getElementById("close");

        function showPopup() {
            popup.classList.add("show");
        }

        close.addEventListener("click", function() {
            popup.classList.remove("show");
        });

        <?php
        if (isset($_POST["deptName"]) ) {
            echo "showPopup();";
        }
        ?>
    </script>




   
   <!-- <script src="script.js"></script> -->
 </body>

 </html>