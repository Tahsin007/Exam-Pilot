// Update last login date in real-time
function updateLastLogin() {
    const lastLogin = document.getElementById("last-login");
    const currentDate = new Date();
    const formattedDate = currentDate.toLocaleDateString();
    lastLogin.textContent = formattedDate;
}

// Simulate dynamic data (total students and courses assigned)
function updateData() {
    const totalStudentsAssignedCount = document.getElementById("total-StudentsAssigned-count");
    const totalCoursesAssignedCount = document.getElementById("total-CoursesAssigned-count");

    // Simulated dynamic data
    const studentsAssigned = 15; // Replace with actual count
    const coursesAssigned = 5; // Replace with actual count

    totalStudentsAssignedCount.textContent = studentsAssigned;
    totalCoursesAssignedCount.textContent = coursesAssigned;
}

// Initialize the page
function init() {
    updateLastLogin();
    updateData();
}

init();
