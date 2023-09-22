 <?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "exam pilot";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM courses";
  $result = $conn->query($sql);

  require_once 'fetchData.php';

  $departments = fetchData("department");
  $faculties = fetchData("faculties");



  if (isset($_GET["course_code"])) {
    $course_code = $_GET["course_code"];

    $sql = "DELETE FROM courses WHERE course_code = '$course_code'";

    if ($conn->query($sql) === TRUE) {
        echo "Course record deleted successfully.";
    } else {
        echo "Error deleting Course record: " . $conn->error;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $deptName = $_POST["deptName"];
    $semester = $_POST["semester"];
    $courseCode = $_POST["courseCode"];
    $credit = $_POST["credit"];
    $courseName = $_POST["courseName"];
    $students = $_POST["students"];
    $session = $_POST["session"];
    $fid = $_POST["1st_examiner_id"];
    $sid = $_POST["2nd_examiner_id"];
    $tid = $_POST["3rd_examiner_id"];

    $sql = "INSERT INTO courses (department, semester, course_code, totall_credit, course_name, totall_students,session,1st_examiner_id,2nd_examiner_id,3rd_examiner_id)
            VALUES ('$deptName', '$semester', '$courseCode', '$credit', '$courseName', '$students','$session','$fid','$sid','$tid')";
    $conn->query($sql);
}





$conn->close();


  ?>


 <!DOCTYPE html>
 <html>

 <head>
   <title>Courses</title>
   <link rel="stylesheet" type="text/css" href="styles.css">
   <link rel="stylesheet" type="text/css" href="styles2.css">

 </head>

 <body>
   <div class="container">
     <div class="menu">
       <div class="sidebar">
         <div class="sidebar-header">
           <h2><i class="fas fa-graduation-cap"></i> Admin Panel</h2>
         </div>
         <ul class="nav">
           <li><a href="/Admin Dashboard/home//home.php"><i class="fas fa-home"></i> Home</a></li>
           <li><a href="/Admin Dashboard/Students/index.php"><i class="fas fa-users"></i> Students</a></li>
           <li><a href="/Admin Dashboard/Faculties/index.php"><i class="fas fa-user-tie"></i> Faculties</a></li>
           <li class="active"><a href="/Admin Dashboard/courses/index2.php"><i class="fas fa-book"></i> Courses</a></li>
           <li><a href="/Admin Dashboard/Departments//index.php"><i class="fas fa-building"></i> Departments</a></li>
           <!-- <li><a href="/Admin Dashboard//Notification//notification.php"><i class="fas fa-bell"></i> Notification</a></li> -->
           <!-- <li><a href="../Update Profile/updateProfile.html"><i class="fas fa-user"></i> Update Profile</a></li> -->
           <li><a href="/Admin Dashboard/Log Out/logout.php"><i class="fas fa-sign-out"></i> Log Out</a></li>
         </ul>
       </div>
     </div>
     <div class="content">
       <div class="section-title">
         <h1>Courses</h1>
       </div>
       <div class="form-section">
         <form action="" method="post" id="courseForm">
           <!-- 1sr form row -->
           <div class="form-row">
             <div class="form-field">
               <label for="deptSelect">Department Name:</label>
               <!-- <input type="text" name="deptName"> -->
               <select class="form-control" id="deptName" name="deptName">
                 <?php foreach ($departments as $department) { ?>
                   <option value="<?php echo $department["dept_name"]; ?>"><?php echo $department["dept_name"]; ?></option>
                 <?php } ?>
               </select>
             </div>
             <div class="form-field">
               <label for="semesterSelect">Select Semester:</label>
               <select id="semesterSelect" name="semester">
                 <option value="1">1</option>
                 <option value="2">2</option>
                 <option value="3">3</option>
                 <option value="4">4</option>
                 <option value="5">5</option>
                 <option value="6">6</option>
                 <option value="7">7</option>
                 <option value="8">8</option>

               </select>
             </div>
           </div>

           <!-- 2nd form row -->

           <div class="form-row">
             <div class="form-field">
               <label for="courseCodeInput">Course Code:</label>
               <input type="text" id="courseCodeInput" name="courseCode">
             </div>
             <div class="form-field">
               <label for="courseNameInput">Course Name:</label>
               <input type="text" id="courseNameInput" name="courseName">
             </div>

           </div>
           <!-- 3rd form row -->

           <div class="form-row">
             <div class="form-field">
               <label for="Session">Session:</label>
               <input type="text" id="session" name="session">
             </div>

             <div class="form-field">
               <label for="creditInput">Total Credit:</label>
               <input type="number" id="creditInput" name="credit">
             </div>

           </div>

           <!-- 4th form row -->

           <div class="form-row">
             <div class="form-field">
               <label for="studentsInput">Total Students:</label>
               <input type="number" id="studentsInput" name="students">
             </div>
             <div class="form-field">
               <label for="1st_examiner_id">1st Examiner Name:</label>
               <!-- <input type="text" id="1st_examiner_id" name="1st_examiner_id"> -->
               <select class="form-control" id="1st_examiner_id" name="1st_examiner_id">
                 <?php foreach ($faculties as $faculty) { ?>
                   <option value="<?php echo $faculty["teacher_id"]; ?>"><?php echo $faculty["teacher_name"]; ?></option>
                 <?php } ?>
               </select>

             </div>
           </div>

           <!-- 5th form row -->

           <div class="form-row">
             <div class="form-field">
               <label for="2nd_examiner_id">2nd Examiner Name:</label>
               <!-- <input type="text" id="1st_examiner_id" name="1st_examiner_id"> -->
               <select class="form-control" id="2nd_examiner_id" name="2nd_examiner_id">
                 <?php foreach ($faculties as $faculty) { ?>
                   <option value="<?php echo $faculty["teacher_id"]; ?>"><?php echo $faculty["teacher_name"]; ?></option>
                 <?php } ?>
               </select>
             </div>
             <div class="form-field">
               <label for="3rd_examiner_id">3rd Examiner Name:</label>
               <!-- <input type="text" id="1st_examiner_id" name="1st_examiner_id"> -->
               <select class="form-control" id="3rd_examiner_id" name="3rd_examiner_id">
                 <?php foreach ($faculties as $faculty) { ?>
                   <option value="<?php echo $faculty["teacher_id"]; ?>"><?php echo $faculty["teacher_name"]; ?></option>
                 <?php } ?>
               </select>
             </div>
           </div>
           <div class="form-buttons">
             <button type="submit" class="btn1">Submit</button>
             <button type="button" class="btn2">Cancel</button>
           </div>
         </form>
       </div>
       <div class="table-section">
         <table id="courseTable">
           <thead>
             <tr>
               <th>Course Code</th>
               <th>Course Name</th>
               <th>Semester</th>
               <th>Dept Name</th>
               <th>Course Credit</th>
               <th>Total Students</th>
               <th>Actions</th>
             </tr>
           </thead>
           <tbody>
             <?php
              if (isset($result) && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td style='text-align: center;'>" . $row["course_code"] . "</td>";
                  echo "<td style='text-align: center;'>" . $row["course_name"] . "</td>";
                  echo "<td style='text-align: center;'>" . $row["semester"] . "</td>";
                  echo "<td style='text-align: center;'>" . $row["department"] . "</td>";
                  echo "<td style='text-align: center;'>" . $row["totall_credit"] . "</td>";
                  echo "<td style='text-align: center;'>" . $row["totall_students"] . "</td>";
                  $courseCode = $row["course_code"];
                  echo "<td style='text-align: center;'><a href='update_course.php?course_code=$courseCode'>Edit</a> | <a href='index2.php?course_code=$courseCode' onclick='return confirm(\"Are you sure you want to delete this Course record?\")'>Delete</a></td>";

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
            <h2>Course Inserted Successfully</h2>
            <p>Your Course data has been inserted into the database.</p>
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
        if (isset($_POST["deptName"]) && isset($_POST["courseCode"]) && isset($_POST["credit"])&& isset($_POST["credit"])&& isset($_POST["1st_examiner_id"])) {
            echo "showPopup();";
        }
        ?>
    </script>




   <!-- <script src="script.js"></script> -->
 </body>

 </html>