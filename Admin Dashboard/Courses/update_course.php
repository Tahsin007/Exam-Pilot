<?php
if (isset($_GET["course_code"])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "exam pilot"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $course_code = $_GET["course_code"];

    $sql = "SELECT * FROM courses WHERE course_code = '$course_code' ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $course_code = $row["course_code"];
        $course_name = $row["course_name"];
        $department = $row["department"];
        $semester=$row["semester"];
        $totall_credit=$row["totall_credit"];
        $totall_students=$row["totall_students"];

        
    } else {
        echo "Student not found.";
        exit;
    }
} else {
    echo "Student ID not provided.";
    exit;
}





if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dept_code = $_POST["dept_code"];
    $dept_name = $_POST["dept_name"];
    $courses = $_POST["courses"];
    $semester = $_POST["semester"];
    $student = $_POST["student"];
    $credit =$_POST["credit"];



    // Update the student data in the database
    $sql = "UPDATE courses SET course_code='$dept_code', course_name='$dept_name', department='$courses', semester='$semester', totall_credit='$student', totall_students= '$credit' WHERE course_code= '$dept_code' ";

    if ($conn->query($sql) === TRUE) {
        echo "Course data updated successfully.";
    } else {
        echo "Error updating Course data: " . $conn->error;
    }
}

// Close the database connection
$conn->close();










?>


<!DOCTYPE html>
<html>
<head>
  <title>Edit Course Details</title>
  <link rel="stylesheet" type="text/css" href="styles2.css">
</head>
<body>
  <div class="container">
    <div class="content">
      <div class="title-section">
        <h1>Edit Course Details</h1>
      </div>
      <div class="form-section">
        <form method="post" action="">
          <!-- <input type="text" name="student_id" value="<?php echo $course_code; ?>"> -->
          <div class="form-field">
            <label for="studentId">Course Code:</label>
            <input type="text" name="dept_code" value="<?php echo $course_code; ?>">
          </div>
          <div class="form-field">
            <label for="studentName">Course Name:</label>
            <input type="text" name="dept_name" value="<?php echo $course_name; ?>" required>
          </div>
          <div class="form-field">
            <label for="emailId">Department Name:</label>
            <input type="text" name="courses" value="<?php echo $department; ?>" >
          </div>
          <div class="form-field">
            <label for="contact">Semester:</label>
            <input type="text" name="semester" value="<?php echo $semester; ?>" >
          </div>
          <div class="form-field">
            <label for="deptName">Totall Credit:</label>
            <input type="text" name="student" value="<?php echo $totall_credit; ?>" >
          </div>
          <div class="form-field">
            <label for="password">Totall Students :</label>
            <input type="text" name="credit" value="<?php echo $totall_students; ?>" >
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
