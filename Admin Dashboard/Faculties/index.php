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
  $teacherDesignation = $_POST["teacherDesignation"];
  $teacherName = $_POST["teacherName"];
  $emailId = $_POST["emailId"];
  $contact = $_POST["contact"];
  $deptName = $_POST["deptName"];
  $password = $_POST["password"];

  $sql = "INSERT INTO faculties (teacher_name, designation, email_id, contact, dept_name, password)
            VALUES ('$teacherName','$teacherDesignation', '$emailId', '$contact', '$deptName', '$password')";
  $conn->query($sql);

}
$sql2 = "SELECT * FROM faculties";
$result2 = $conn->query($sql2);

require_once 'fetchData.php';

$departments = fetchData("department");




if (isset($_GET["teacher_id"])) {
    $teacherId = $_GET["teacher_id"];

    $sql = "DELETE FROM faculties WHERE teacher_id = '$teacherId'";

    if ($conn->query($sql) === TRUE) {
        echo "Teacher record deleted successfully.";
    } else {
        echo "Error deleting teacher record: " . $conn->error;
    }
}

$conn->close();

?>



<!DOCTYPE html>
<html>

<head>
  <title>Faculty Management</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="styles.css">

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
        <li class="active"><a href="/Admin Dashboard/Faculties/index.php"><i class="fas fa-user-tie"></i> Faculties</a></li>
        <li><a href="/Admin Dashboard/courses/index2.php"><i class="fas fa-book"></i> Courses</a></li>
        <li><a href="/Admin Dashboard/Departments//index.php"><i class="fas fa-building"></i> Departments</a></li>
        <!-- <li><a href="/Admin Dashboard//Notification//notification.php"><i class="fas fa-bell"></i> Notification</a></li> -->
        <!-- <li><a href="../Update Profile/updateProfile.html"><i class="fas fa-user"></i> Update Profile</a></li> -->
        <li><a href="/Admin Dashboard//Log Out/logout.php"><i class="fas fa-sign-out"></i> Log Out</a></li>
      </ul>
    </div>
    <div class="content">
      <div class="title-section">
        <h1>Faculties</h1>
      </div>
      <div class="form-section">
        <form action="index.php" method="post" id="myForm">
          <div class="form-row">
            <div class="form-field">
              <label for="teacherId">Teacher Name:</label>
              <input type="text" name="teacherName" required>
            </div>
            <div class="form-field">
              <label for="studentName">Teacher Designation:</label>
              <input type="text" name="teacherDesignation" required>
            </div>
            <div class="form-field">
              <label for="emailId">Email ID:</label>
              <input type="text" name="emailId" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-field">
              <label for="contact">Contact:</label>
              <input type="tel" name="contact" required>
            </div>

            <div class="form-field">
              <!-- <label for="deptName">Dept. Name:</label>
              <input type="text" name="deptName" required> -->
              <label for="deptName">Dept Name:</label>
              <select class="form-control" id="deptName" name="deptName">
                <?php foreach ($departments as $department) { ?>
                  <option value="<?php echo $department["dept_name"]; ?>"><?php echo $department["dept_name"]; ?></option>
                <?php } ?>
                <!-- Add more options here -->
              </select>
            </div>
            <div class="form-field">
              <label for="password">Password:</label>
              <input type="password" name="password" required>
            </div>
          </div>
          <div class="form-actions">
            <input type="submit" class="btn1" value="Submit">
            <!-- <button type="submit" class="btn1">Submit</button> -->
            <button type="button" onclick="cancelForm()" class="btn2">Cancel</button>
          </div>
        </form>
      </div>
      <div class="table-section">
        <table id="studentsTable">
          <thead>
            <tr>
              <th>Teacher ID</th>
              <th>Teacher Name</th>
              <th>Designation</th>
              <th>Email ID</th>
              <th>Contact</th>
              <th>Dept. Name</th>
              <th>Password</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Loop through the retrieved records and display them in the table
            if ($result2->num_rows > 0) {
              while ($row2 = $result2->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row2["teacher_id"] . "</td>";
                echo "<td>" . $row2["teacher_name"] . "</td>";
                echo "<td>" . $row2["designation"] . "</td>";
                echo "<td>" . $row2["email_id"] . "</td>";
                echo "<td>" . $row2["contact"] . "</td>";
                echo "<td>" . $row2["dept_name"] . "</td>";
                echo "<td>" . $row2["password"] . "</td>";
                $teacherId = $row2["teacher_id"];
                echo "<td><a href='update_teacher.php?teacher_id=$teacherId'>Edit</a> | <a href='index.php?teacher_id=$teacherId' onclick='return confirm(\"Are you sure you want to delete this teacher record?\")'>Delete</a></td>";

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
      <h2>Data Inserted Successfully</h2>
      <p>Your teacher data has been inserted into the database.</p>
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
    if (isset($_POST["teacherName"]) && isset($_POST["teacherDesignation"])) {
      echo "showPopup();";
    }
    ?>
  </script>


  <!-- <script src="script.js"></script> -->
</body>

</html>