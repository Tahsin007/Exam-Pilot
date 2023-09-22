// Simulated student data (replace this with actual data fetched from a database)
const studentData = {
    studentID: "MUH2025027M",
    studentName: "Imtiaz Chowdhury",
    department: "Software Engineering",
    semester: "5",
    dob: "13/01/2001",
    gender: "Male"
};

// Function to populate student information
function populateStudentInfo() {
    document.getElementById("student-id").textContent = studentData.studentID;
    document.getElementById("student-name").textContent = studentData.studentName;
    document.getElementById("department").textContent = studentData.department;
    document.getElementById("semester").textContent = studentData.semester;
    document.getElementById("dob").textContent = studentData.dob;
    document.getElementById("gender").textContent = studentData.gender;
}

// Call the function to populate student information
populateStudentInfo();