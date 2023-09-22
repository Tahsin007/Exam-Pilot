document.addEventListener("DOMContentLoaded", function () {
    const confirmLogoutButton = document.getElementById("confirm-logout");

    // Add event listener for clicking Log Out button
    confirmLogoutButton.addEventListener("click", function () {
        // Perform logout actions here (e.g., clearing session, redirecting to login page)
        // Replace this with your actual logout logic

        // Display a logout message
        const logoutMessage = document.createElement("div");
        logoutMessage.textContent = "Log Out Successful!!";
        logoutMessage.classList.add("logout-message");
        document.body.appendChild(logoutMessage);

        // Redirect to login.html after a delay (e.g., 3 seconds)
        setTimeout(function () {
            window.location.href = "../../login.html";
        }, 500);
    });
});
