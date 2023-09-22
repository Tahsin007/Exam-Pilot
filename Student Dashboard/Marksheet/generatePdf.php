<?php
// include autoloader
// require(__DIR__ . '/vendor/autoload.php');
session_start();

if (!isset($_SESSION["student_id"])) {
    echo "Student ID is not set up.";
    header("Location: http://localhost:3000/Login/login.php"); // Redirect to the login page if not logged in
    exit();
}

$student_id = $_SESSION["student_id"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam pilot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// require __DIR__ . "/dompdf/vendor/autoload.php";
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;


// $dompdf = new Dompdf;
$dompdf = new Dompdf;

function calculateGrade($marks)
{
    // Add your grading criteria here
    if ($marks >= 80) {
        return 'A+';
    } elseif ($marks >= 75) {
        return 'A';
    } elseif ($marks >= 70) {
        return 'A-';
    } elseif ($marks >= 65) {
        return 'B+';
    } elseif ($marks >= 60) {
        return 'B';
    } elseif ($marks >= 55) {
        return 'B-';
    } elseif ($marks >= 50) {
        return 'C+';
    } elseif ($marks >= 45) {
        return 'C';
    } elseif ($marks >= 40) {
        return 'C-';
    } else {
        return 'F';
    }
}

function calculateCGPA($marks)
{
    // Add your grading criteria here
    if ($marks >= 80) {
        return '4.00';
    } elseif ($marks >= 75) {
        return '3.75';
    } elseif ($marks >= 70) {
        return '3.50';
    } elseif ($marks >= 65) {
        return '3.25';
    } elseif ($marks >= 60) {
        return '3.00';
    } elseif ($marks >= 55) {
        return '2.75';
    } elseif ($marks >= 50) {
        return '2.50';
    } elseif ($marks >= 45) {
        return '2.25';
    } elseif ($marks >= 40) {
        return '2.00';
    } else {
        return '0.00';
    }
}

$sql3 = "SELECT * FROM students WHERE student_id = '$student_id' ";
$result3 = $conn->query($sql3);

if (isset($result3) && $result3->num_rows == 1) {
    $row3 = $result3->fetch_assoc();

    $id = $row3["student_id"];
    $name = $row3["student_name"];
    $email = $row3["email_id"];
    $contact = $row3["contact"];
    $dept_name = $row3["dept_name"];
    $semester = $row3["semester"];
    $password = $row3["password"];
} else {
    echo "Records not found";
    header("Location: http://localhost:3000/Login/login.php");
    exit();
}

$sql_courses = "SELECT DISTINCT course_code FROM student_marks WHERE student_id = '$student_id'";
$result_courses = $conn->query($sql_courses);

generatePDF($student_id, $name,$email, $dept_name,$semester,$contact,$result_courses);

// Generate PDF using Dompdf
function generatePDF($id, $name, $email, $dept_name, $semester, $contact, $result_courses)
{
    $options = new Options(); 
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $options->setIsRemoteEnabled(true);

    $options->setChroot(__DIR__);
    $dompdf = new Dompdf($options);

    // HTML content for the PDF
    $html = '<html>
        <head>
        <style>.img_cont{display: flex; justify-content: center; align-items: center; width: 100vw; height: 100vh;}</style>
        </head>
        <body>
            <!-- Include the student data and table contents here -->
            <div class="img_cont">
            <img src="nstu.png" style="height: 80px; width: 50px; display:block;  margin-left: 335px;">
            </div>
            
            <h2 style="color:black;text-align:center;">Noakhali Science and Technology University</h2>
            <h3 style="color:black;text-align:center;">Sonapur, Noakhali-3814, Bangladesh</h3>
            <h3 style="color:black;background: #ece4e4bf;text-align:center;">ACADEMIC TRANSCRIPT</h3>
            
            <div style="border: 0.2px solid #000;margin-bottom: 5px;padding-left: 20px;">
            <p><strong>Student ID:</strong> ' . $id . '</p>
            <p><strong>Department:</strong> ' . $dept_name . '</p>
            <p><strong>Email:</strong> ' . $email . '</p>
            <p><strong>Student Name:</strong> ' . $name . '</p>
            <p><strong>Semester/Year:</strong> ' . $semester . '</p>
            <p><strong>Contact:</strong> ' . $contact . '</p>
            </div>

             <div1 >
            <table border="1" width="100%">
                <thead>
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Credit</th>
                        <th>CT Marks</th>
                        <th>Attendance Marks</th>
                        <th>Total Marks</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>';
    $totall_cgpa = 0.00;
    $totalPoints = 0.00;
    $totallCredit = 0.00;
    while ($row_courses = $result_courses->fetch_assoc()) {
        $course_code = $row_courses["course_code"];

        // Query to fetch marks for the given student and course
        $sql = "SELECT * FROM student_marks WHERE student_id = '$id' AND course_code = '$course_code'";
        $result = $GLOBALS['conn']->query($sql);

        $sql4 = "SELECT sm.course_code, c.1st_examiner_id,c.2nd_examiner_id,c.3rd_examiner_id,c.course_name, c.totall_credit, sm.totall_marks, sm.grade  
                FROM student_marks as sm 
                INNER JOIN courses as c ON sm.course_code = c.course_code
                WHERE c.course_code = '$course_code' ";

        $result4 = $GLOBALS['conn']->query($sql4);

        if (isset($result4) && $result4->num_rows > 0) {
            $row4 = $result4->fetch_assoc();
            $course_name = $row4["course_name"];
            $first_examiner_id= $row4["1st_examiner_id"];
            $second_examiner_id = $row4["2nd_examiner_id"];
            $third_examiner_id = $row4["3rd_examiner_id"];

            $totall_credit = $row4["totall_credit"];
        } else {
            echo "Records not found for fetching the course details";
        }

        if ($result->num_rows > 0) {
            $teacher1_final_marks = 0;
            $teacher2_final_marks = 0;
            $teacher3_final_marks = 0;
            $final_marks_to_use = 0;
            $marks = [];
            $ct1Marks = 0;
            $ct2Marks = 0;
            $ct3Marks = 0;
            $attendanceMarks = 0;

            while ($row = $result->fetch_assoc()) {
                $teacher_id = $row['teacher_id'];
                if ($teacher_id == $first_examiner_id) {
                    $ct1Marks = $row['ct1_marks'];
                    $ct2Marks = $row['ct2_marks'];
                    $ct3Marks = $row['ct3_marks'];
                    $attendanceMarks = $row['attendance_marks'];
                }
                $marks[$teacher_id] = $row['final_marks'];
            }

            if (isset($marks[$first_examiner_id]) && isset($marks[$second_examiner_id])) {
                $teacher1_final_marks = $marks[$first_examiner_id];
                $teacher2_final_marks = $marks[$second_examiner_id];
                $teacher3_final_marks = (isset($marks[$third_examiner_id])) ? $marks[$third_examiner_id] : 0;
                $difference = abs($teacher1_final_marks - $teacher2_final_marks);

                if ($difference > 14) {
                    $teacher1_diff = abs($teacher1_final_marks  - $teacher3_final_marks);
                    $teacher2_diff = abs($teacher2_final_marks - $teacher3_final_marks);
                    $closest_teacher_id = ($teacher1_diff < $teacher2_diff) ? $first_examiner_id : $second_examiner_id;
                    $final_marks_to_use = ($teacher3_final_marks + $marks[$closest_teacher_id]) / 2;
                } else {
                    $final_marks_to_use = ($teacher1_final_marks + $teacher2_final_marks) / 2;
                }

                $marksArray = array($ct1Marks, $ct2Marks, $ct3Marks);
                rsort($marksArray);
                $bestMarks = array_slice($marksArray, 0, 2);
                $averageOfBestMarks = array_sum($bestMarks) / count($bestMarks);
                $total_marks = $final_marks_to_use + $averageOfBestMarks + $attendanceMarks;
                $grade = calculateGrade($total_marks);

                $totallCredit += $totall_credit;
                $checkCredit = 0;
                $grade = calculateGrade($total_marks);
                $cgpa = calculateCGPA($total_marks);
                if ($cgpa == '0.00') {
                    $totallCredit -= $totall_credit;
                }
                $points = $cgpa * (float)$totall_credit;
                // echo "$points";
                $totalPoints = $totalPoints + $points;
                $totall_cgpa += (float)$cgpa;

                // Add the course data to the HTML table
                $html .= '<tr>';
                $html .= '<td style="text-align: center;">' . $course_code . '</td>';
                $html .= '<td style="text-align: center;">' . $course_name . '</td>';
                $html .= '<td style="text-align: center;">' . $totall_credit . '</td>';
                $html .= '<td style="text-align: center;">' . $averageOfBestMarks . '</td>';
                $html .= '<td style="text-align: center;">' . $attendanceMarks . '</td>';
                $html .= '<td style="text-align: center;">' . $total_marks . '</td>';
                $html .= '<td style="text-align: center;">' . $grade . '</td>';
                $html .= '</tr>';
            } else {
                echo "Marks from teacher_id 1 and 2 are required for course code $course_code.<br><br>";
            }
        } else {
            echo "No marks found for student ID $id and course code $course_code.<br><br>";
        }
    }
    $avg = (float)$totalPoints / (float) $totallCredit;
    $formattedNumber = number_format($avg, 2);
    $html .="<tr>";
    // echo " <td style='text-align: center;'>" . $avg . "</td>";
    // echo "<td style='text-align: center;'>" . $totall_cgpa . "</td>";
    $html .="<td style='text-align: center;'>Completed Credit:</td>";
    $html .=" <td style='text-align: left;'>" . $totallCredit . "</td>";
    $html .= "<td style='text-align: center;'></td>";
    $html .= "<td style='text-align: center;'></td>";
    $html .= "<td style='text-align: center;'></td>";
    // $html .= "<td style='text-align: center;'></td>";
    // $html .= "<td style='text-align: center;'></td>";
    $html .= "<td style='text-align: center;'>TGPA: </td>";
    $html .= " <td style='text-align: center;'>" . $formattedNumber . "</td>";
    // echo "Average CGPA: ".(float)$formattedNumber;
    echo "</tr>";

    $html .= '</tbody></table>';

    // $html .= '<div style="display: flex; flex-direction: column; justify-content: space-between;">
    //      <div> Credit Completed: ' . $totallCredit . '</div>
    //      <div style="margin-left: 20px;"> TGPA: ' . $formattedNumber . '</div>
    // </div>';

    // $html .= '<p> "Total Credit Completed:" . $totallCredit.";"</p>';
    // $html .= "Credit Completed: " . $totallCredit;

    //     $html .= '<div style="display: flex; flex-direction: column; justify-content: space-between;">
    //     <div> Credit Completed: ' . $totallCredit . '</div>
    //     <div style="margin-left: 20px;"> TGPA: ' . $formattedNumber . '</div>
    // </div>';


    // $html .= 'Credit Completed:  ' . $totallCredit;
    // $html .= 'TGPA:  ' . $formattedNumber;

    // $html .= " <td style='text-align: left;'>" . $totallCredit . "</td>";
    // $html .= " <td style='text-align: right;'>" . $formattedNumber . "</td>";


    // $html .= "Average TGPA: " . $formattedNumber;
    
    $html .= '</body></html>';


    try {
        // Generate the PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Output the PDF to the browser
        $dompdf->stream("marksheet.pdf");
    } catch (Exception $e) {
        // Handle any exceptions that occur during PDF generation
        echo "Error: " . $e->getMessage();
    }
}



$conn->close();

?>