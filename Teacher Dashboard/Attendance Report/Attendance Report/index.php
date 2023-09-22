 <?php

  session_start();
  if (!isset($_SESSION["teacher_id"])) {
    header("Location: http://localhost:3000/Login/login.php");
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

    $semester = $_POST["semester"];
    $course_code = $_POST["course_code"];
    $select_date = $_POST["select_date"];

    $sql = "SELECT * FROM attendance WHERE date = '$select_date' AND course_code='$course_code' AND semester='$semester'";
    $result = $conn->query($sql);

    // if ($conn->query($sql) === TRUE) {
    //     echo "Data inserted successfully.";
    // } else {
    //     echo "Error: " . $sql . "<br>" . $conn->error;
    // }
  }

  $sql3 = "SELECT * FROM courses WHERE 1st_examiner_id = '$teacher_id' ";

  $result3 = $conn->query($sql3);

  // $courseName=[];
  if (isset($result3) && $result3->num_rows > 0) {
    while ($row3 = $result3->fetch_assoc()) {
      $courseCode[] = $row3;
      // $courseName = $row3["course_name"];
    }
  } else {
    echo "<tr><td colspan='7'>No records found</td></tr>";
    header("Location: http://localhost:3000/Login/login.php");
    exit();
  }
  require_once 'fetchData.php';

  $departments = fetchData("department");

  // Close the database connection
  // $conn->close();

  ?>


 <!DOCTYPE html>
 <html lang="en">

 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Attendance Report</title>
   <link rel="stylesheet" href="styles.css">
   <link rel="stylesheet" href="styles2.css">
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
         <li class="active"><a href="/Teacher Dashboard/Attendance Report/Attendance Report/index.php"><i class="fas fa-file-alt"></i> Attendance
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
       <div class="section-title">Attendance Report</div>
       <div class="form-section">
         <form action="index.php" method="post">
           <div class="form-row">
             <div class="form-field">
               <label for="studentIDInput">Dept Name:</label>
               <!-- <input type="text" id="deptName" required> -->
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
               <input type="number" name="semester" id="semester" required>
             </div>
           </div>
           <div class="form-row">
             <div class="form-field">
               <label for="ct3MarksInput">Course Code:</label>
               <!-- <input type="text" name="course_code"> -->
               <select class="form-control" id="course_code" name="course_code">
                 <?php foreach ($courseCode as $course_code) { ?>
                   <option value="<?php echo $course_code["course_code"]; ?>"><?php echo $course_code["course_code"] ?> <?php echo $course_code["course_name"]; ?></option>
                 <?php } ?>
               </select>
             </div>
           </div>
           <div class="form-row">
             <div class="form-field">
               <label for="date">Select Date:</label>
               <input type="date" name="select_date">
             </div>
           </div>
           <input type="submit" value="Fetch Details" class="submit-button">
         </form>
       </div>

       <div class="form-buttons">
         <button class="submit-button" hidden>Fetch Details</button>
         <!-- <button class="cancel-button">Cancel</button> -->
       </div>
       <div class="table-section">
         <table id="marksTable">
           <thead>
             <tr>
               <th>Student ID</th>
               <th>Student Name</th>
               <th>Course Code</th>
               <th>Dept Name</th>
               <th>Semester</th>
               <th>Status</th>
               <th>Date</th>
             </tr>
           </thead>
           <tbody id="marksTableBody">
             <?php
              if (isset($result) && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td style='text-align: center;'>" . $row["ID"] . "</td>";
                  echo "<td style='text-align: center;'>" . $row["student_name"] . "</td>";
                  echo "<td style='text-align: center;'>" . $row["course_code"] . "</td>";
                  echo "<td style='text-align: center;'>" . $row["dept_name"] . "</td>";
                  echo "<td style='text-align: center;'>" . $row["semester"] . "</td>";
                  echo "<td style='text-align: center;'>" . $row["status"] . "</td>";
                  echo "<td style='text-align: center;'>" . $row["date"] . "</td>";

                  // $courseCode = $row["course_code"];
                  // echo "<td style='text-align: center;'><a href='update_course.php?course_code=$courseCode'>Edit</a> | <a href='deleter_course.php?course_code=$courseCode' onclick='return confirm(\"Are you sure you want to delete this Course record?\")'>Delete</a></td>";

                  echo "</tr>";
                }
              } else {
                echo "<tr><td colspan='7'>No records found</td></tr>";
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

   <!-- <script src="script.js"></script> -->
 </body>

 </html>