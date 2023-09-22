<?php
if (isset($_GET["student_id"])) {
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "exam pilot";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $studentId = $_GET["student_id"];

  $sql = "SELECT * FROM students WHERE student_id = '$studentId' ";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $studentName = $row["student_name"];
    $studentId = $row["student_id"];
    $emailId = $row["email_id"];
    $contact = $row["contact"];
    $deptName = $row["dept_name"];
    $password = $row["password"];
    $semester = $row["semester"];
    $session = $row["session"];


    
  } else {
    echo "Student not found.";
    exit;
  }
} else {
  echo "Student ID not provided.";
  exit; // Exit the script if no student ID is provided
}




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentId = $_POST["student_id"];
    $studentName = $_POST["student_name"];
    $emailId = $_POST["email_id"];
    $contact = $_POST["contact"];
    $deptName = $_POST["deptName"];
    $password =$_POST["password"];
    $semester = $_POST["semester"];
    $session = $_POST["session"];


    $sql = "UPDATE students SET password='$password',semester='$semester',session='$session', dept_name='$deptName', contact='$contact', student_name='$studentName', email_id='$emailId', student_id= '$studentId' WHERE student_id= '$studentId' ";

    if ($conn->query($sql) === TRUE) {
        echo "Student data updated successfully.";
    } else {
        echo "Error updating student data: " . $conn->error;
    }
}


$conn->close();






?>


<!DOCTYPE html>
<html>

<head>
  <title>Edit Student Details</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
  <div class="container">
    <div class="content">
      <div class="title-section">
        <h1>Edit Student Details</h1>
      </div>
      <div class="form-section">
        <form method="post" action="">
          <!-- <input type="text" name="student_id" value="<?php echo $studentId; ?>"> -->
          <div class="form-field">
            <label for="studentId">Student ID:</label>
            <input type="text" name="student_id" value="<?php echo $studentId; ?>">
          </div>
          <div class="form-field">
            <label for="studentName">Student Name:</label>
            <input type="text" name="student_name" value="<?php echo $studentName; ?>" required>
          </div>
          <div class="form-field">
            <label for="emailId">Email ID:</label>
            <input type="text" name="email_id" value="<?php echo $emailId; ?>">
          </div>
          <div class="form-field">
            <label for="contact">Contact:</label>
            <input type="text" name="contact" value="<?php echo $contact; ?>">
          </div>
          <div class="form-field">
            <label for="deptName">Dept Name:</label>
            <input type="text" name="deptName" value="<?php echo $deptName; ?>">
          </div>
          <div class="form-field">
            <label for="password">Password :</label>
            <input type="text" name="password" value="<?php echo $password; ?>">
          </div>
          <div class="form-field">
            <label for="semester">Semester :</label>
            <input type="text" name="semester" value="<?php echo $semester; ?>">
          </div>
          <div class="form-field">
            <label for="session">Session :</label>
            <input type="text" name="session" value="<?php echo $session; ?>">
          </div>
          <div class="form-actions">
            <button type="submit" class="btn1">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>