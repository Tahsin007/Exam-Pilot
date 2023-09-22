<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam pilot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET["student_id"])) {
    $studentId = $_GET["student_id"];

    $sql = "DELETE FROM students WHERE student_id = '$studentId'";

    if ($conn->query($sql) === TRUE) {
        echo "Student record deleted successfully.";
    } else {
        echo "Error deleting student record: " . $conn->error;
    }
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentId = $_POST["studentId"];
    $studentName = $_POST["studentName"];
    $emailId = $_POST["emailId"];
    $contact = $_POST["contact"];
    $deptName = $_POST["deptName"];
    $password = $_POST["password"];
    $semester = $_POST["semester"];
    $session = $_POST["session"];

    $sql = "INSERT INTO students (student_id, student_name, email_id, contact, dept_name, password,semester,session)
            VALUES ('$studentId', '$studentName', '$emailId', '$contact', '$deptName', '$password','$semester','$session')";

    $conn->query($sql);
}


$conn->close();
?>




<!DOCTYPE html>
<html>

<head>
  <title>Student Management</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
  <?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "exam pilot";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM students";
  $result = $conn->query($sql);

  require_once 'fetchData.php';

  $departments = fetchData("department");

  ?>

  <div class="none">
    <div class="sidebar">
      <div class="sidebar-header">
        <h2><i class="fas fa-graduation-cap"></i> Admin Panel</h2>
      </div>
      <ul class="nav">
        <li><a href="/Admin Dashboard/home//home.php"><i class="fas fa-home"></i> Home</a></li>
        <li class="active"><a href="/Admin Dashboard/Students/index.php"><i class="fas fa-users"></i> Students</a></li>
        <li><a href="/Admin Dashboard/Faculties/index.php"><i class="fas fa-user-tie"></i> Faculties</a></li>
        <li><a href="/Admin Dashboard/courses/index2.php"><i class="fas fa-book"></i> Courses</a></li>
        <li><a href="/Admin Dashboard/Departments//index.php"><i class="fas fa-building"></i> Departments</a></li>
        <!-- <li><a href="/Admin Dashboard//Notification//notification.php"><i class="fas fa-bell"></i> Notification</a></li> -->
        <!-- <li><a href="../Update Profile/updateProfile.html"><i class="fas fa-user"></i> Update Profile</a></li> -->
        <li><a href="/Admin Dashboard//Log Out/logout.php"><i class="fas fa-sign-out"></i> Log Out</a></li>
      </ul>
    </div>
    <div class="content">
      <div class="title-section">
        <h1>Students</h1>
      </div>
      <div class="form-section">
        <form id="myForm" action="" method="post">
          <div class="form-row">
            <div class="form-field">
              <label for="studentId">Student ID:</label>
              <input type="text" name="studentId" required>
            </div>
            <div class="form-field">
              <label for="studentName">Student Name:</label>
              <input type="text" name="studentName" required>
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
              <label for="deptName">Dept. Name:</label>
              <!-- //<input type="text" name="deptName" required> -->
              <select class="form-control" id="deptName" name="deptName">
                <?php foreach ($departments as $department) { ?>
                  <option value="<?php echo $department["dept_name"]; ?>"><?php echo $department["dept_name"]; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-field">
              <label for="password">Password:</label>
              <input type="password" name="password" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-field">
              <label for="semester">Semester:</label>
              <input type="number" name="semester" required>
            </div>
            <div class="form-field">
              <label for="session">Session:</label>
              <input type="text" name="session" required>
            </div>

          </div>
          <div class="form-actions">
            <button type="submit" class="btn1">Submit</button>
            <button type="button" onclick="cancelForm()" class="btn2">Cancel</button>
          </div>
        </form>
      </div>
      <div class="table-section">
        <table id="studentsTable">
          <thead>
            <tr>
              <th>Student ID</th>
              <th>Student Name</th>
              <th>Email ID</th>
              <th>Contact</th>
              <th>Dept. Name</th>
              <th>Password</th>
              <th>Semester</th>
              <th>Session</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["student_id"] . "</td>";
                echo "<td>" . $row["student_name"] . "</td>";
                echo "<td>" . $row["email_id"] . "</td>";
                echo "<td>" . $row["contact"] . "</td>";
                echo "<td>" . $row["dept_name"] . "</td>";
                echo "<td>" . $row["password"] . "</td>";
                echo "<td>" . $row["semester"] . "</td>";
                echo "<td>" . $row["session"] . "</td>";
                $studentId = $row["student_id"];
                echo "<td><a href='update_student.php?student_id=$studentId'>Edit</a> | <a href='index.php?student_id=$studentId' onclick='return confirm(\"Are you sure you want to delete this student record?\")'>Delete</a></td>";

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
            <h2>Student Info Inserted Successfully</h2>
            <p>Student Info has been inserted into the database.</p>
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
        if (isset($_POST["studentId"]) && isset($_POST["studentName"]) && isset($_POST["deptName"])) {
            echo "showPopup();";
        }
        ?>
    </script>
  <!-- <script src="script.js"></script> -->
</body>


</script>

</html>