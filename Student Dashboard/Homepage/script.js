// Update last login date in real-time
function updateLastLogin() {
    const lastLogin = document.getElementById("last-login");
    const currentDate = new Date();
    const formattedDate = currentDate.toLocaleDateString();
    lastLogin.textContent = formattedDate;
}

// Simulate dynamic data (total courses and semesters)
function updateData() {
    const totalCoursesCount = document.getElementById("total-courses-count");
    const totalSemesterCount = document.getElementById("total-semester-count");

    // Simulated dynamic data
    const courses = 10; // Replace with actual count
    const semesters = 8; // Replace with actual count

    totalCoursesCount.textContent = courses;
    totalSemesterCount.textContent = semesters;
}

// Initialize the page
function init() {
    updateLastLogin();
    updateData();
}

init();
