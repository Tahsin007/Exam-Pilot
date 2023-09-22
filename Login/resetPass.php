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
    // Retrieve the new password and confirmation password
    $newPassword = $_POST["new-password"];
    $confirmPassword = $_POST["confirm-password"];

    // Validate that the new password and confirmation password match
    if ($newPassword != $confirmPassword) {
        echo "New password and confirmation password do not match.";
    } else {
        // Determine the table name based on the email domain
        $email = $_SESSION["user_email"];
        $emailDomain = substr($email, strpos($email, "@") + 1);
        $tableName = "";

        switch ($emailDomain) {
            case "student.nstu.edu.bd":
                $tableName = "students";
                break;
            case "nstu.edu.bd":
                $tableName = "faculties";
                break;
            case "examcontroller.nstu.edu.com":
                $tableName = "exam_controller";
                break;
            case "admin.gmail.com":
                $tableName = "admin";
                break;
            default:
                // Email format is not recognized
                echo "Email not recognized or invalid.";
                exit;
        }

        if (!empty($tableName)) {
            // Update the password in the respective table (as plain text)
            $sql = "UPDATE $tableName SET password = '$newPassword' WHERE email_id = '$email'";

            if ($conn->query($sql) === TRUE) {
                // Store a success flag in the session to indicate successful password reset
                $_SESSION["password_reset_success"] = true;
                
                // Redirect to login page after performing the password reset
                header("Location: Login.php");
                exit;
            } else {
                echo "Error updating password: " . $conn->error;
            }
        } else {
            echo "Email not recognized or invalid.";
        }
    }
}

$conn->close();
?>







<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
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

        input[type=password] {
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

            input[type=password] {
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
            <h1 style="font-family: 'Poppins Medium'; color: rgb(248, 170, 14);">Create A New Password</h1>
            <p class="subtitle" style="font-family: 'Poppins Light'; color:rgb(223, 219, 226); ">
                Give a strong password to keep secure your account.</p>

            <form action="#" method="post">
                <label for="new-password">New Password:</label>
                <input type="password" id="new-password" name="new-password" placeholder="Enter a new password"
                    required>
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm-password"
                    placeholder="Re-enter the new password" required>
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
</body>

</html>