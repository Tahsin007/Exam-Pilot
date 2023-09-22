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
    $courseCode = $_POST["courseCode"];
    $studentId = $_POST["studentId"];
    $ct1Marks = $_POST["ct1Marks"];
    $ct2Marks = $_POST["ct2Marks"];
    $ct3Marks = $_POST["ct3Marks"];
    $attendanceMarks = $_POST["attendanceMarks"];
    $finalMarks = $_POST["finalMarks"];
    $teacher_id = $_POST["teacher_id"];

  $marksArray = [$ct1Marks, $ct2Marks, $ct3Marks];

  rsort($marksArray);

  $highestMarks = array_slice($marksArray, 0, 2);

  $averageOfHighestMarks = array_sum($highestMarks) / count($highestMarks);
  $totalMarks = $finalMarks+$averageOfHighestMarks+ $attendanceMarks;
  $gpa="";
  if($totalMarks>=80){
    $gpa="A+";
  }else if($totalMarks>=75){
    $gpa="A";
  }else if($totalMarks>=70){
    $gpa="A-";
  }else if($totalMarks>=65){
    $gpa="B+";
  }
  else if($totalMarks>=60){
    $gpa="B";
  }else if($totalMarks>=55){
    $gpa="B-";
  }else if($totalMarks>=50){
    $gpa="C+";
  }else if($totalMarks>=45){
    $gpa="C";
  }else if($totalMarks>=40){
    $gpa="C";
  }else{
    $gpa="Fail";
  }

    $sql = "INSERT INTO student_marks (teacher_id, course_code, student_id, ct1_marks, ct2_marks, ct3_marks, attendance_marks,final_marks,totall_marks,grade)
            VALUES ('$teacher_id', '$courseCode', '$studentId', '$ct1Marks', '$ct2Marks', '$ct3Marks','$attendanceMarks','$finalMarks','$totalMarks','$gpa')";

    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}

$conn->close();
?>