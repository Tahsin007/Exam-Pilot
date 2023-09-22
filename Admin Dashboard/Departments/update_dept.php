<?php
if (isset($_GET["dept_code"])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "exam pilot"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $dept_code = $_GET["dept_code"];

    $sql = "SELECT * FROM department WHERE dept_code = '$dept_code' ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $dept_code = $row["dept_code"];
        $dept_name = $row["dept_name"];
        $totall_courses = $row["totall_courses"];
        $totall_semester=$row["totall_semester"];
        $totall_student=$row["totall_student"];
        $totall_credit=$row["totall_credit"];

        // $conn->close();
    } else {
        echo "department not found.";
        exit; 
    }
} else {
    echo "department ID not provided.";
    exit; 
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dept_code = $_POST["dept_code"];
    $dept_name = $_POST["dept_name"];
    $courses = $_POST["courses"];
    $semester = $_POST["semester"];
    $student = $_POST["student"];
    $credit =$_POST["credit"];



    $sql = "UPDATE department SET dept_code='$dept_code', dept_name='$dept_name', totall_courses='$courses', totall_semester='$semester', totall_student='$student', totall_credit= '$credit' WHERE dept_code= '$dept_code' ";

    if ($conn->query($sql) === TRUE) {
        echo "Department data updated successfully.";
    } else {
        echo "Error updating department data: " . $conn->error;
    }
}

$conn->close();



?>


<!DOCTYPE html>
<html>
<head>
  <title>Edit Department Details</title>
  <link rel="stylesheet" type="text/css" href="styles2.css">
</head>
<body>
  <div class="container">
    <div class="content">
      <div class="title-section">
        <h1>Edit Department Details</h1>
      </div>
      <div class="form-section">
        <form method="post" action="">
          <!-- <input type="text" name="student_id" value="<?php echo $studentId; ?>"> -->
          <div class="form-field">
            <label for="studentId">Department Code:</label>
            <input type="text" name="dept_code" value="<?php echo $dept_code; ?>">
          </div>
          <div class="form-field">
            <label for="studentName">Department Name:</label>
            <input type="text" name="dept_name" value="<?php echo $dept_name; ?>" required>
          </div>
          <div class="form-field">
            <label for="emailId">Totall Courses:</label>
            <input type="text" name="courses" value="<?php echo $totall_courses; ?>" >
          </div>
          <div class="form-field">
            <label for="contact">Totall Semester:</label>
            <input type="text" name="semester" value="<?php echo $totall_semester; ?>" >
          </div>
          <div class="form-field">
            <label for="deptName">Totall Students:</label>
            <input type="text" name="student" value="<?php echo $totall_student; ?>" >
          </div>
          <div class="form-field">
            <label for="password">Totall Credits :</label>
            <input type="text" name="credit" value="<?php echo $totall_credit; ?>" >
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
