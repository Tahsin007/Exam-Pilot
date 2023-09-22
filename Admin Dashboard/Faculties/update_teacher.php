<?php
if (isset($_GET["teacher_id"])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "exam pilot"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $teacherId = $_GET["teacher_id"];

    $sql = "SELECT * FROM faculties WHERE teacher_id = '$teacherId' ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $teacherName = $row["teacher_name"];
        $emailId = $row["email_id"];
        $contact = $row["contact"];
        $deptName=$row["dept_name"];
        $password=$row["password"];
       
    } else {
        echo "Teacher not found.";
        exit; // Exit the script if the student is not found
    }
} else {
    echo "Teacher ID not provided.";
    exit; // Exit the script if no student ID is provided
}






if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teacherId = $_POST["teacher_id"];
    $teacherName = $_POST["teacher_name"];
    $emailId = $_POST["email_id"];
    $contact = $_POST["contact"];
    $deptName = $_POST["deptName"];
    $password =$_POST["password"];



    $sql = "UPDATE faculties SET password='$password', dept_name='$deptName', contact='$contact', teacher_name='$teacherName', email_id='$emailId', teacher_id= '$teacherId' WHERE teacher_id= '$teacherId' ";

    if ($conn->query($sql) === TRUE) {
        echo "Teacher data updated successfully.";
    } else {
        echo "Error updating teacher data: " . $conn->error;
    }
}

$conn->close();





?>


<!DOCTYPE html>
<html>
<head>
  <title>Edit Faculties Details</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="container">
    <div class="content">
      <div class="title-section">
        <h1>Edit Faculties Details</h1>
      </div>
      <div class="form-section">
        <form method="post" action="">
          <!-- <input type="text" name="student_id" value="<?php echo $teacherId; ?>"> -->
          <div class="form-field">
            <label for="studentId">Teacher ID:</label>
            <input type="text" name="teacher_id" value="<?php echo $teacherId; ?>">
          </div>
          <div class="form-field">
            <label for="studentName">Teacher Name:</label>
            <input type="text" name="teacher_name" value="<?php echo $teacherName; ?>" required>
          </div>
          <div class="form-field">
            <label for="emailId">Email ID:</label>
            <input type="text" name="email_id" value="<?php echo $emailId; ?>" >
          </div>
          <div class="form-field">
            <label for="contact">Contact:</label>
            <input type="text" name="contact" value="<?php echo $contact; ?>" >
          </div>
          <div class="form-field">
            <label for="deptName">Dept Name:</label>
            <input type="text" name="deptName" value="<?php echo $deptName; ?>" >
          </div>
          <div class="form-field">
            <label for="password">Password :</label>
            <input type="text" name="password" value="<?php echo $password; ?>" >
          </div>
          <!-- Add other form fields as needed -->
          <div class="form-actions">
            <button type="submit" class="btn1">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
