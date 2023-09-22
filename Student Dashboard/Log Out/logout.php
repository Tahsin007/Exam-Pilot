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
    <title>Student Panel</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <!-- Left Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-graduation-cap"></i> Student Panel</h2>
        </div>
        <ul class="nav">
            <li><a href="/Student Dashboard/Homepage/home.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="/Student Dashboard/Courses/courses.php"><i class="fas fa-book"></i> Courses</a></li>
            <li><a href="/Student Dashboard/Faculties/faculties.php"><i class="fas fa-users"></i> Faculties</a></li>
            <li><a href="/Student Dashboard/Marksheet/marksheetwithpdf.php"><i class="fas fa-file-text"></i> Marksheet</a></li>
            <li><a href="/Student Dashboard/Attendance Report/attendanceReport.php"><i class="fas fa-list-alt"></i> AttendanceReport</a></li>
            <li><a href="/Student Dashboard/Update Profile/updateProfile.php"><i class="fas fa-user"></i> Update Profile</a></li>
            <!-- <li><a href="/Student Dashboard/Notification/notification.php"><i class="fas fa-bell"></i> Notification</a></li> -->
            <li class="active"><a href="/Student Dashboard/Log Out/logout.php"><i class="fas fa-sign-out"></i> Log Out</a></li>
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
                    <input type="submit" name="confirm-logout" id="confirm-logout" value="Log Out">
                    <!-- <button id="confirm-logout">Log Out</button> -->

                </div>
            </form>
        </div>
    </div>

    <!-- <script src="script.js"></script> -->
</body>

</html>