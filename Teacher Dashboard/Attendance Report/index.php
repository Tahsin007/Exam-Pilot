 <?php
  // Database configuration
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
    // Retrieve form data
    $deptName = $_POST["semester"];
    $course_code = $_POST["course_code"];
    $select_date = $_POST["select_date"];


    // Prepare and execute an SQL INSERT statement
    $sql = "SELECT * FROM attendance WHERE date = '$select_date' AND course_code='$course_code' ";
    $result = $conn->query($sql);

    // if ($conn->query($sql) === TRUE) {
    //     echo "Data inserted successfully.";
    // } else {
    //     echo "Error: " . $sql . "<br>" . $conn->error;
    // }
}

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
       <div class="section-title">Attendance Report</div>
       <div class="form-section">
         <form action="index.php" method="post">
           <div class="form-row">
             <div class="form-field">
               <label for="studentIDInput">Dept Name:</label>
               <input type="text" id="deptName" required>
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
               <input type="text" name="course_code">
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