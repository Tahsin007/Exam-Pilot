
// Simulated data for notifications (replace with data from admin)
const notifications = [
    {
        heading: "Result",
        text: "Your first semester result is just updated now. Check your Marksheet section to download the full result."
    },
    {
        heading: "Attendance",
        text: "Your 1st semester attendance sheet is updated recently. Check the Attendance Report section."
    }
    // Add more notifications here
];




// Check if there are notifications
const hasNotifications = true; // Replace with your logic to check notifications

// Get the content container and set the background image accordingly
const contentContainer = document.getElementById("notification-container");

if (hasNotifications) {
    // If there are notifications, remove background image or set to a different one
    contentContainer.style.backgroundImage = "none";
} else {
    // If there are no notifications, set the background image
    contentContainer.style.backgroundImage = "url('image/logo.jpeg')";
    // Add other CSS properties for background sizing, positioning, etc.
}

// Function to create and display notifications
function displayNotifications() {
    const container = document.getElementById("notification-container");

    notifications.forEach(notification => {
        const notificationDiv = document.createElement("div");
        notificationDiv.classList.add("notification");
        notificationDiv.innerHTML = `
        <h2>${notification.heading}</h2>
        <p>${notification.text}</p>
        `;
        container.appendChild(notificationDiv);
    });
}

// Call the function to display notifications
displayNotifications();