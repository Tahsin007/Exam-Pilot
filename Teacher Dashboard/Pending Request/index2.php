<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Marks</title>
  <link rel="stylesheet" href="style2.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

</head>
<body>
  <div class="container">
    <div class="menu">
      <div class="menu-icon">&#9776;</div>
      <ul class="menu-items">
        <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
        <li><i class="fa-solid fa-code-pull-request"></i> Pending Request</a></li>
        <li><a href="#"><i class="fa-sharp fa-solid fa-square-check"></i> Enter Marks</a></li>
        <li><a href="#"><i class="fa-solid fa-chalkboard-user"></i> Mark Attendance</a></li>
        <li><a href="#"><i class="fa-sharp fa-solid fa-file"></i>Attendance Report</a></li>
        <li><a href="#"><i class="fa-solid fa-user-graduate"></i>Assigned Subjects</a></li>
        <li><a href="#"><i class="fa-sharp fa-solid fa-file"></i> Marksheet Report</a></li>
        <li><a href="#"><i class="fa-sharp fa-solid fa-bell"></i> Notification</a></li>
        <li><a href="#"><i class="fa-solid fa-user"></i> Update Profile</a></li>
        <li><a href="#"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a></li>
      </ul>
    </div>
    <div class="content">
      <div class="section-title">Question Transfer</div>
    <div class="form-container">

    <form>
      <div class="form-section">
        <label for="select1">Select Dept:</label>
        <select id="select1" name="select1">
        <option value="option1">Software Engineering</option>
        <option value="option2">Computer Science</option>
        <option value="option3">Pharmacy</option>
      </select>
      </div>
      <div class="form-section">
        <label for="select2">Select Semester:</label>
        <select id="select2" name="select2">
        <option value="option1">1</option>
        <option value="option2">2</option>
        <option value="option3">3</option>
        <option value="option4">4</option>
        <option value="option5">5</option>
        <option value="option6">6</option>
        <option value="option7">7</option>
        <option value="option8">8</option>
      </select>
      </div>
      <div class="form-section">
        <label for="select3">Select Course:</label>
      <select id="select3" name="select3">
        <option value="option1">Introduction To Programming</option>
        <option value="option2">Data Structure & ALgorithm</option>
        <option value="option3">Object Oriented Programming</option>
      </select>
      </div>
      <div class="form-section">
        <label for="text-input">Course Code:</label>
        <input type="text" id="text-input" name="text-input">
      </div>
      <div class="form-section">
        <label for="file-upload">Question Upload:</label>
        <input type="file" id="file-upload" name="file-upload">
      </div>

      <div class="btn">
        <button type="submit" class="submit-button">Submit</button>
        <button class="cancel-button">Cancel</button>

      </div>
    </form>
  </div>
    </div>
  </div>

  <script src="script2.js"></script>
</body>
</html>
