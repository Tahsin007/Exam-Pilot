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
    <title>Teacher Panel</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <!-- Left Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-graduation-cap"></i> Teacher Panel</h2>
        </div>
        <ul class="nav">
            <li><a href="/Teacher Dashboard/Home/Home/index.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="/Teacher Dashboard/Pending Request/Pending Request/index1.php"><i class="fas fa-user-clock"></i> Pending Request</a>
            </li>
            <!-- <li><a href=""><i class="fas fa-question-circle"></i> Send Question</a> -->
            </li>
            <li><a href="/Teacher Dashboard/Enter Marks/Enter Marks/index.php"><i class="fas fa-edit"></i> Enter Marks</a></li>
            <li><a href="/Teacher Dashboard/Mark Attendance/Mark Attendance//index.php"><i class="fas fa-clipboard-list"></i> Mark
                    Attendance</a></li>
            <li><a href="/Teacher Dashboard/Attendance Report/Attendance Report/index.php"><i class="fas fa-file-alt"></i> Attendance
                    Report</a></li>
            <li><a href="/Teacher Dashboard/Assigned Subject/Assigned Subjects/index.php"><i class="fas fa-book"></i> Assigned Subjects</a>
            </li>
            <li><a href="/Teacher Dashboard/Marksheet Report/Marksheet Report/index.php"><i class="fas fa-file-signature"></i> Marksheet
                    Report</a></li>
            <li><a href="/Teacher Dashboard/send question/index.php"><i class="fas fa-file-signature"></i> Send Question</a></li>

            <li><a href="/Exam Controller//send questions/send question/send questions/index.php"><i class="fas fa-file-signature"></i> Receive Questions</a></li>

            <li><a href="/Teacher Dashboard/Notification/notification.php"><i class="fas fa-bell"></i> Notifications</a></li>
            <li><a href="/Teacher Dashboard/Update Profile/Update Profile/index.php"><i class="fas fa-user"></i> Update Profile</a></li>
            <li class="active"><a href="/Teacher Dashboard/Log Out/logout.php"><i class="fas fa-sign-out"></i> Log Out</a></li>
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
                    <button type="submit" name="confirm-logout" id="confirm-logout">Log Out</button>
                    <!-- <input type="submit" id="confirm-logout" name="confirm-logout" value="Log Out"> -->


                </div>
            </form>

        </div>
    </div>

    <!-- <script src="script.js"></script> -->
</body>

</html>