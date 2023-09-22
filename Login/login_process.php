<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam pilot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    

    // $emailParts = explode('@', $email);
    // if (count($emailParts) == 2) {
    //     $domainParts = explode('.', $emailParts[1]);
    //         if (count($domainParts) > 1 && $domainParts[0] == 'admin') {
    //             // Valid admin email
    //             //echo "Valid admin email!";

    //             $sql3 = "SELECT * FROM admin WHERE admin_email = '$email' ";
    //             $result3 = $conn->query($sql3);
    //             if ($result3->num_rows == 1) {
    //                 $row3 = $result3->fetch_assoc();
    //                 if ($password == $row3["password"]) {
    //                 // Authentication successful
    //                 // header("Location: adminPage.php"); // Redirect to admin dashboard
    //                 $_SESSION["admin_id"] = $row3["admin_id"];
    //                 header("Location: http://localhost:3000/Admin%20Dashboard/Homepage/index.php");
                    
    //                 }
    //             else {
    //                 echo "Incorrect password.";
    //             }
    //         }

    //         } else {
    //             // Not a valid admin email
    //             echo "Not a valid admin email!";
    //         }
    // }

    $allowedDomain = "examcontroller.nstu.edu.com";
    $allowedAdmin = "admin.gmail.com";



    if (!endsWith($email, 'nstu.edu.bd') && !preg_match("/@{$allowedDomain}$/", $email) &&
    !preg_match("/@{$allowedAdmin}$/", $email)) {
        echo "<script>alert('Sorry You need to log in with a valid Institutional Mail');</script>";
        exit;
    }

    //Student
    $sql = "SELECT * FROM students WHERE email_id = '$email' ";
    $result = $conn->query($sql);

    //Teacher
    $sql2 = "SELECT * FROM faculties WHERE email_id = '$email' ";
    $result2 = $conn->query($sql2);

    //Exam Controller
    $sql3 = "SELECT * FROM exam_controller WHERE email = '$email' ";
    $result3 = $conn->query($sql3);

    $sql4 = "SELECT * FROM admin WHERE admin_email = '$email' ";
    $result4 = $conn->query($sql4);


    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($password == $row["password"]) {
            // Authentication successful
            $_SESSION["student_id"] = $row["student_id"];
            // header("Location: http://localhost:3000/Student%20Dashboard/Homepage/home.php"); // Redirect to student dashboard
            header("Location: http://localhost:3000/Student%20Dashboard/Homepage/home.php"); // Redirect to student dashboard

        }
        else {
            echo "Incorrect password.";
        }
    } else if ($result2->num_rows == 1){
        $row2 = $result2->fetch_assoc();
        if ($password == $row2["password"]) {
            // Authentication successful
            $_SESSION["teacher_id"] = $row2["teacher_id"];
            $_SESSION["teacher_name"] = $row2["teacher_name"];
            header("Location: http://localhost:3000/Teacher%20Dashboard/Home/Home/index.php"); // Redirect to student dashboard
        }
        else {
            echo "Incorrect password.";
        }
    } else if ($result3->num_rows == 1) {
        $row3 = $result3->fetch_assoc();
        if ($password == $row3["password"]) {
            // Authentication successful
            $_SESSION["controller_id"] = $row3["Id"];
            header("Location: http://localhost:3000/Exam%20Controller/home/home.php"); // Redirect to student dashboard
        } else {
            echo "Incorrect password.";
        }
    } else if ($result4->num_rows == 1) {
        $row4 = $result4->fetch_assoc();
        if ($password == $row4["password"]) {
            // Authentication successful
            $_SESSION["admin_id"] = $row4["admin_id"];
            header("Location: http://localhost:3000/Admin%20Dashboard/home/home.php"); // Redirect to student dashboard
        } else {
            echo "Incorrect password.";
        }
    }
    else {
        echo "Email not found.";
    }
}

// Close the database connection
$conn->close();

function endsWith($haystack, $needle) {
    return substr($haystack, -strlen($needle)) === $needle;
}
