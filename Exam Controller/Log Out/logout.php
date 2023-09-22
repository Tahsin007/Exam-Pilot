<?php
session_start();

if (isset($_POST["confirm-logout"])) {
    session_unset();

    session_destroy();

    header("Location: http://localhost:3000/Login/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Exam Controller Panel</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <!-- Left Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-graduation-cap"></i> Exam Controller Panel</h2>
        </div>
        <ul class="nav">
            <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="/Exam Controller/Send Request/sendRequest.php"><i class="fas fa-envelope"></i> Send Request</a></li>
            <li><a href="/Exam Controller/send questions/send question/send questions/sendQuestion.php"><i class="fas fa-question-circle"></i> Send Question</a>
            </li>
            <li><a href="/Teacher Dashboard/send question/receiveQuestion.php"><i class="fas fa-question-circle"></i> Receive Question</a></li>

            <!-- <li><a href="/Exam Controller/Notification//notification.php"><i class="fas fa-bell"></i> Notification</a></li> -->
            <!-- <li><a href="../Result Approval/resultApproval.html"><i class="fas fa-check-circle"></i> Result Approval</a> -->
            <!-- </li> -->
            <li><a href="/Exam Controller/Update Profile/updateProfile.php"><i class="fas fa-user"></i> Update Profile</a></li>
            <li class="active"><a href="/Exam Controller/Log Out/logout.php"></i> Log Out</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="header">

            <div class="user-info">
                <div class="user-details">
                    <h1 style="color: rgb(250, 250, 250);">Log Out</h1>

                </div>

            </div>

        </div>

        <div class="body">
            <form action="" method="post">
                <div class="logout-dialog">
                    <h2 style="color: #333;">Confirm Logout</h2>
                    <p>Are you sure you want to log out?</p>
                    <button name="confirm-logout" id="confirm-logout">Log Out</button>
                    <!-- <input type="submit" name="confirm-logout" value="Log Out"> -->

                </div>
            </form>


        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>