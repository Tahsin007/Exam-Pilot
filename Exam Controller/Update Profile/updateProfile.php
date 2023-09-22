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
            <li><a href="/Exam Controller//home//home.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="/Exam Controller/Send Request/sendRequest.php"><i class="fas fa-envelope"></i> Send Request</a></li>
            <li><a href="/Exam Controller/send questions/send question/send questions/sendQuestion.php"><i class="fas fa-question-circle"></i> Send Question</a>
            </li>
            <li><a href="/Teacher Dashboard/send question/receiveQuestion.php"><i class="fas fa-question-circle"></i> Receive Question</a></li>

            <!-- <li><a href="/Exam Controller/Notification//notification.php"><i class="fas fa-bell"></i> Notification</a></li> -->
            <!-- <li><a href="../Result Approval/resultApproval.html"><i class="fas fa-check-circle"></i> Result Approval</a> -->
            <!-- </li> -->
            <li class="active"><a href="/Exam Controller/Update Profile/updateProfile.php"><i class="fas fa-user"></i> Update Profile</a></li>
            <li><a href="/Exam Controller/Log Out/logout.php"></i> Log Out</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="header">
            <!-- <img src="../home/image/Imtiaz Chowdhury.jpg" alt="Profile Picture" class="profile-pic"> -->

            <div class="user-info">
                <div class="user-details">
                    <!-- <h3 style="color: rgb(0, 0, 0);">Mr PROFESSOR</h3> -->

                </div>

            </div>

        </div>

        <div class="body">
            <h2 style="color: rgb(246, 105, 40);">Edit Profile & Credentials</h2>

            <!-- Form for updating profile -->
            <form id="profile-form">
                <div class="form-group">
                    <label for="first-name">First Name:</label>
                    <input type="text" id="first-name" name="first-name" placeholder="Enter First Name">
                </div>
                <div class="form-group">
                    <label for="last-name">Last Name:</label>
                    <input type="text" id="last-name" name="last-name" placeholder="Enter Last Name">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Enter Email">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter Password">
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter Phone">
                </div>
                <div class="button-group">

                    <button type="button" id="cancel-button">Cancel</button>
                    <button type="button" id="save-button">Save</button>
                </div>
            </form>

        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>