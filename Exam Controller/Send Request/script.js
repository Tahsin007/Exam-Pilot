// Function to show a confirmation message
function showConfirmationMessage(message) {
    const confirmationMessage = document.createElement("div");
    confirmationMessage.classList.add("confirmation-message");
    confirmationMessage.textContent = message;
    document.body.appendChild(confirmationMessage);

    // Automatically remove the message after a few seconds (adjust as needed)
    setTimeout(() => {
        confirmationMessage.remove();
    }, 3000); // Remove the message after 3 seconds (3000 milliseconds)
}

// Function to show an alert message
function showAlertMessage(message) {
    alert(message);
}

// Define the form element
const form = document.querySelector('form');

// Add an event listener to the form for submission
form.addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the form from submitting normally

    // Get the input values
    const departmentValue = document.getElementById("department").value;
    const semesterValue = document.getElementById("semester").value;
    const courseValue = document.getElementById("course").value;
    const courseCodeValue = document.getElementById("courseCode").value;
    const teacherValue = document.getElementById("teacher").value;
    const syllabusValue = document.getElementById("syllabus").value;
    const questionPatternValue = document.getElementById("questionPattern").value;
    const deadlineValue = document.getElementById("deadline").value;

    // Check if any of the input fields are empty
    if (!departmentValue || !semesterValue || !courseValue || !courseCodeValue || !teacherValue || !syllabusValue || !questionPatternValue || !deadlineValue) {
        showAlertMessage('Please Input Data Correctly!!');
        return; // Stop form submission
    }

    // Display the success message
    showConfirmationMessage('Request Sent Successfully');

    // Optionally, clear the form fields
    form.reset();
});

// Add an event listener to the "Cancel" button to clear input data
const cancelButton = document.getElementById('cancelButton');
cancelButton.addEventListener('click', function () {
    form.reset();
});
