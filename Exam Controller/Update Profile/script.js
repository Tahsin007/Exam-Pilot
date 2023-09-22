// Get form elements and save button
const profileForm = document.getElementById("profile-form");
const firstNameInput = document.getElementById("first-name");
const lastNameInput = document.getElementById("last-name");
const emailInput = document.getElementById("email");
const passwordInput = document.getElementById("password");
const phoneInput = document.getElementById("phone");
const saveButton = document.getElementById("save-button");

// Function to check if any input field has a valid value
function hasValidInput() {
    return (
        firstNameInput.value.trim() !== "" ||
        lastNameInput.value.trim() !== "" ||
        emailInput.value.trim() !== "" ||
        passwordInput.value.trim() !== "" ||
        phoneInput.value.trim() !== ""
    );
}

// Function to toggle the save button's visibility
function toggleSaveButton() {
    saveButton.style.display = hasValidInput() ? "block" : "none";
}

// Event listeners for input fields to toggle save button
firstNameInput.addEventListener("input", toggleSaveButton);
lastNameInput.addEventListener("input", toggleSaveButton);
emailInput.addEventListener("input", toggleSaveButton);
passwordInput.addEventListener("input", toggleSaveButton);
phoneInput.addEventListener("input", toggleSaveButton);

// Initial toggle of save button
toggleSaveButton();

// Save button click event handler
saveButton.addEventListener("click", function () {
    // Validate and save data to the database here (replace with your logic)
    const data = {
        firstName: firstNameInput.value,
        lastName: lastNameInput.value,
        email: emailInput.value,
        password: passwordInput.value,
        phone: phoneInput.value,
    };

    // You can send 'data' to your server for saving/updating in the database

    // Show the confirmation message
    showConfirmationMessage("Info Save Successfully");

    // Clear form fields after saving
    profileForm.reset();
});

// Cancel button click event handler
document.getElementById("cancel-button").addEventListener("click", function () {
    // Clear form fields
    profileForm.reset();
});

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
