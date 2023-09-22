<?php
session_start();

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam pilot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function sendVerificationCode($email, $verificationCode) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'exampilot.nstu@gmail.com'; // Gmail email address
        $mail->Password = 'flgkqmehikxknweq'; // Gmail password or app-specific password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('exampilot.nstu@gmail.com', 'Exam Pilot');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Verification Code';
        $mail->Body = "Your verification code is: $verificationCode";

        $mail->send();
        return true; // Email sent successfully
    } catch (Exception $e) {
        return false; // Email sending failed
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    $sql = "SELECT * FROM students WHERE email_id = '$email' ";
    $result = $conn->query($sql);

    $sql2 = "SELECT * FROM faculties WHERE email_id = '$email' ";
    $result2 = $conn->query($sql2);

    $sql3 = "SELECT * FROM exam_controller WHERE email = '$email' ";
    $result3 = $conn->query($sql3);

    $sql4 = "SELECT * FROM admin WHERE admin_email = '$email' ";
    $result4 = $conn->query($sql4);

    if ($result->num_rows == 1 || $result2->num_rows == 1 || $result3->num_rows == 1 || $result4->num_rows == 1) {
        // Email exists in one of the tables
        $verificationCode = generateVerificationCode();
        $_SESSION["verification_code"] = $verificationCode;
        $_SESSION["user_email"] = $email;

        if (sendVerificationCode($email, $verificationCode)) {

            // Store a success flag in the session to indicate successful code send
                $_SESSION["verification_code_success"] = true;
            // Email sent successfully, redirect to submitCode.php
            header("Location: submitCode.php");
            exit; // Ensure that no further code execution occurs
        } else {
            echo "Failed to send the verification code.";
        }
    } else {
        echo "Email not found in our records.";
    }
}

$conn->close();

function generateVerificationCode() {
    return rand(1000, 9999);
}
?>





<!DOCTYPE html>
<html>

<head>
    <title>Forgot Password Page</title>
    <style>
        body {
            background-color: white;
            font-family: Poppins, Poppins Light;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 50px;
            margin-left: 100px;
            margin-right: 100px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px #888888;
        }

        .left-container {
            flex: 1;
            background-color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .logo {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo img {
            width: 100%;
            max-width: 200px;
        }

        .right-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgb(76, 93, 105);
            color: white;
            padding: 100px;
            border-radius: 10px;
        }

        h1 {
            font-size: 24px;
            color: #333333;
            margin-bottom: 20px;
            font-family: 'Barlow Condensed';
            font-weight: bold;
            font-style: italic;
            font-size: 24px;
        }

        p.subtitle {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: left;
            width: 100%;
        }

        input[type=email] {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border-style: none none solid none;
            border-color: #ccc;
            width: 100%;
            font-size: 16px;
            color: #333333;
            background-color: white;
            outline: none;
            box-shadow: none;
            height: auto;
            line-height: normal;
            resize: none;
            font-family: 'Poppins', Poppins Light;
            font-weight: normal;
            text-transform: none;
            text-indent: 0;
            text-shadow: none;
            display: block;
            padding-left: 0.5em;
            padding-right: .5em;
        }

        input[type=submit] {
            background-color: #ff8533;
            width: 105%;
            border-radius: 5px;
            border-style: none;
            border-width: 0px;
            color: #fff;
            cursor: pointer;
            font-size: .9em;
            font-weight: bold;
            margin-top: .5em;
            padding: .8em .5em .8em .5em;
            text-align: center;
        }

        input[type=submit]:hover {
            background-color: #ff6600;
        }

        input[type=submit]:active {
            transform: scale(0.95);
        }

        a {
            color: rgb(248, 170, 14);
        }

        a:hover {
            color: #ff8533;
        }

        .error-message {
            color: red;
        }

        .success-message {
            color: green;
        }

        @media only screen and (max-width: 768px) {
            body {
                margin-top: -20px;
            }

            h1 {
                font-size: 20px;
            }

            input[type=email] {
                font-size: .8em;
            }

            input[type=submit] {
                font-size: .8em;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="left-container">
            <h1>EXAM PILOT</h1>
            <div class="logo">
                <img src="logo.jpeg" alt="Logo">
                <p class="subtitle">An automated examination management system by NSTU</p>
            </div>
        </div>
        <div class="right-container">
            <h1 style="font-family: 'Poppins Medium'; color: rgb(248, 170, 14);">Forget Password?</h1>
            <p class="subtitle" style="font-family: 'Poppins Light'; color:rgb(223, 219, 226); ">
                Enter your email to receive a verification code</p>

            <form action="" method="post">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Give your educational mail" required>
                <input type="submit" value="Get Code">
            </form>
        </div>
    </div>
</body>

</html>