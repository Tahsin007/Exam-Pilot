// Update last login date in real-time
function updateLastLogin() {
    const lastLogin = document.getElementById("last-login");
    const currentDate = new Date();
    const formattedDate = currentDate.toLocaleDateString();
    lastLogin.textContent = formattedDate;
}

// Simulate dynamic data (total courses and semesters)
function updateData() {
    const totalStudentsCount = document.getElementById("total-students-count");
    const totalFacultiesCount = document.getElementById("total-faculties-count");
    const totalCoursesCount = document.getElementById("total-courses-count");
    const totalDepartmentsCount = document.getElementById("total-departments-count");

    // Simulated dynamic data
    const students = 1200;
    const faculties = 200;
    const courses = 100;
    const departments = 12;

    totalStudentsCount.textContent = students;
    totalFacultiesCount.textContent = faculties;
    totalCoursesCount.textContent = courses;
    totalDepartmentsCount.textContent = departments;
}

// Initialize the page
function init() {
    updateLastLogin();
    updateData();
}

init();
