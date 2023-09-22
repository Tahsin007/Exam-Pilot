<?php
if (isset($_POST["submit"])) {
    // File upload logic
    $targetDir = "C:/Users/TANIM/Desktop/Upload Dir/";

    $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
        echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    

    // Encryption logic
    $inputFile = $targetFile;
    $outputFile = "uploads/encrypted_file.pdf";

    $secretKey = generateRandomKey(); // Generate a random secret key
    $iv = generateRandomIV(); // Generate a random IV

    $fileContent = file_get_contents($inputFile);
    $encryptedFile = openssl_encrypt($fileContent, 'aes-256-cbc', $secretKey, 0, $iv);

    file_put_contents($outputFile, $encryptedFile);

    // Database storage logic
    $teacherId = $_POST["teacher_id"]; // Replace with the actual teacher ID
    $fileName = basename($targetFile);

    $conn = new mysqli("localhost", "root", "", "your_database_name");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO teacher_files (teacher_id, file_name, encrypted_file, secret_key, iv) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $teacherId, $fileName, $encryptedFile, $secretKey, $iv);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

// Function to generate a random secret key
function generateRandomKey()
{
    return bin2hex(random_bytes(32)); // 32 bytes for AES-256
}

// Function to generate a random IV
function generateRandomIV()
{
    return openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
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
            <li class="active"><a href="/Exam Controller/send questions/sendQuestion.php"><i class="fas fa-question-circle"></i> Send Question</a>
            </li>
            <!-- <li><a href="/Exam Controller/Notification//notification.php"><i class="fas fa-bell"></i> Notification</a></li> -->
            <!-- <li><a href="../Result Approval/resultApproval.html"><i class="fas fa-check-circle"></i> Result Approval</a> -->
            <!-- </li> -->
            <li><a href="/Exam Controller/Update Profile/updateProfile.php"><i class="fas fa-user"></i> Update Profile</a></li>
            <li><a href="/Exam Controller/Log Out/logout.php"></i> Log Out</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="header">

            <div class="user-info">
                <div class="user-details">
                    <h1 style="color: rgb(250, 250, 250);">Send Question</h1>

                </div>

            </div>

        </div>

        <div class="body">

            <form>
                <div class="form-group">
                    <label class="form-label" for="department">Select Department:</label>
                    <select class="form-control" id="department" name="department">
                        <option value="dept1">IIT</option>
                        <option value="dept2">CSTE</option>
                        <option value="dept3">ICE</option>

                        <!-- Add more options here -->
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="semester">Select Semester:</label>
                    <select class="form-control" id="semester" name="semester">
                        <option value="sem1">Semester 1</option>
                        <option value="sem2">Semester 2</option>
                        <option value="sem3">Semester 3</option>
                        <!-- Add more options here -->
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="course">Select Course:</label>
                    <select class="form-control" id="course" name="course">
                        <option value="course1">Introdiction to SOftware Engineering</option>
                        <option value="course2">OOP-I</option>
                        <option value="course3">Theory of Computing</option>
                        <!-- Add more options here -->
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="courseCode">Course Code:</label>
                    <input type="text" class="form-control" id="courseCode" name="courseCode" placeholder="Please Enter Course Code">
                </div>
                <div class="form-group">
                    <label class="form-label" for="teacher">Select Superintendant:</label>
                    <select class="form-control" id="teacher" name="teacher">
                        <option value="teacher4">Tasniya Ahmed</option>
                        <option value="teacher1">Falguni Roy</option>
                        <option value="teacher2">Eusha Kadir</option>
                        <option value="teacher3">Iftekharul Alam Ifat</option>
                        <option value="teacher5">Sarwar Alom</option>

                        <!-- Add more options here -->
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="question">Question:</label>
                    <input type="file" class="form-control file-input" id="question" name="question">
                </div>

                <div class="form-buttons">
                    <button type="submit" name="submit" class="btn btn-primary">Send Question</button>
                    <button type="button" id="cancelButton" class="btn btn-primary">Cancel</button>
                </div>
            </form>



        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>