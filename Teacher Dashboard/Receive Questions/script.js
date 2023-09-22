// Simulated data for notifications (replace with data from admin)
const notifications = [

    {
        heading: "Result",
        text: "Your first semester result is just updated now. Check your Marksheet section to download the full result."
    },
    {
        heading: "Attendance",
        text: "Your 1st semester attendance sheet is updated recently. Check the Attendance Report section."
    },



    {
        heading: "Question Approval",
        text: "You have received a request to Accept question from the moderation committee with question set.",
        details: {
            subjectCode: "CSE1001",
            course: "Programming",
            semester: "1st",
            department: "Software Engineering",
            sentFrom: "Moderation Committee",
            question: "mainQuestion.pdf"
        }
    }
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

    notifications.forEach((notification, index) => {
        const notificationDiv = document.createElement("div");
        notificationDiv.classList.add("notification");
        const notificationContent = document.createElement("div");
        notificationContent.classList.add("notification-content");
        notificationContent.innerHTML = `
        <h2>${notification.heading}</h2>
        <p>${notification.text}</p>
        `;
        notificationDiv.appendChild(notificationContent);

        // Check if the notification has details to display
        if (notification.details && notification.text.split('\n').length > 3) {
            // Create a details div to show the second part
            const detailsDiv = document.createElement("div");
            detailsDiv.classList.add("notification-details");
            detailsDiv.innerHTML = `
                <p>Subject Code: ${notification.details.subjectCode}</p>
                <p>Course: ${notification.details.course}</p>
                <p>Semester: ${notification.details.semester}</p>
                <p>Dept: ${notification.details.department}</p>
                <p>Sent From: ${notification.details.sentFrom}</p>
            `;

            // Check if there's a link in the notification
            if (notification.details.question) {
                // Create a download link for the question paper
                const downloadLink = document.createElement("a");
                downloadLink.textContent = "Download Question Paper";
                downloadLink.href = notification.details.question;
                downloadLink.setAttribute("download", "mainQuestion.pdf"); // Set the filename for download

                // Append the download link to the details div
                detailsDiv.appendChild(downloadLink);

                // Create "Accept" and "Reject" buttons
                const acceptButton = document.createElement("button");
                acceptButton.textContent = "Accept";
                acceptButton.classList.add("accept-button");
                acceptButton.setAttribute("data-index", index);

                const rejectButton = document.createElement("button");
                rejectButton.textContent = "Reject";
                rejectButton.classList.add("reject-button");
                rejectButton.setAttribute("data-index", index);

                // Append the buttons to the details div
                detailsDiv.appendChild(acceptButton);
                detailsDiv.appendChild(rejectButton);
            }

            notificationDiv.appendChild(detailsDiv);
        }

        // Add an "Expand" button for notifications with details
        if (notification.details) {
            const expandButton = document.createElement("button");
            expandButton.classList.add("expand-button");
            expandButton.textContent = "Expand";
            expandButton.setAttribute("data-index", index);
            notificationContent.appendChild(expandButton);
        }

        container.appendChild(notificationDiv);
    });
}

// Call the function to display notifications
displayNotifications();

// Function to handle notification expansion
function handleExpandClick(event) {
    if (event.target.classList.contains("expand-button")) {
        const index = event.target.getAttribute("data-index");
        const notification = notifications[index];
        const notificationContent = event.target.parentElement;

        // Remove the "Expand" button
        event.target.remove();

        // Check if the notification has details to display
        if (notification.details) {
            // Create a details div to show the second part
            const detailsDiv = document.createElement("div");
            detailsDiv.classList.add("notification-details");
            detailsDiv.innerHTML = `
                <p>Subject Code: ${notification.details.subjectCode}</p>
                <p>Course: ${notification.details.course}</p>
                <p>Semester: ${notification.details.semester}</p>
                <p>Dept: ${notification.details.department}</p>
                <p>Sent From: ${notification.details.sentFrom}</p>
            `;

            // Check if there's a link in the notification
            if (notification.details.question) {
                // Create a download link for the question paper
                const downloadLink = document.createElement("a");
                downloadLink.textContent = "Download Question Paper";
                downloadLink.href = notification.details.question;
                downloadLink.setAttribute("download", "mainQuestion.pdf"); // Set the filename for download

                // Append the download link to the details div
                detailsDiv.appendChild(downloadLink);

                // Create "Accept" and "Reject" buttons
                const acceptButton = document.createElement("button");
                acceptButton.textContent = "Accept";
                acceptButton.classList.add("accept-button");
                acceptButton.setAttribute("data-index", index);

                const rejectButton = document.createElement("button");
                rejectButton.textContent = "Reject";
                rejectButton.classList.add("reject-button");
                rejectButton.setAttribute("data-index", index);

                // Append the buttons to the details div
                detailsDiv.appendChild(acceptButton);
                detailsDiv.appendChild(rejectButton);
            }

            notificationContent.appendChild(detailsDiv);
        }
    }
}

// Attach event listener for notification expansion
document.getElementById("notification-container").addEventListener("click", handleExpandClick);
