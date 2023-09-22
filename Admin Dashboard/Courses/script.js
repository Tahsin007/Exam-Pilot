// Check if there is any stored data in localStorage
var storedData = localStorage.getItem("coursesData");
var coursesData = storedData ? JSON.parse(storedData) : [];

// Function to update the table with the stored data
function updateTable() {
  var table = document.getElementById("courseTable");
  var tbody = table.getElementsByTagName("tbody")[0];
  tbody.innerHTML = "";

  for (var i = 0; i < coursesData.length; i++) {
    var rowData = coursesData[i];
    var newRow = tbody.insertRow();
    newRow.setAttribute("data-index", i); // Set data-index attribute to identify the row index

    for (var j = 0; j < rowData.length; j++) {
      var cell = newRow.insertCell();
      cell.textContent = rowData[j];
    }

    var actionCell = newRow.insertCell();
    var editButton = document.createElement("button");
    editButton.textContent = "Edit";
    editButton.className = "btn1";
    editButton.addEventListener("click", editRecord);
    actionCell.appendChild(editButton);

    var deleteButton = document.createElement("button");
    deleteButton.textContent = "Delete";
    deleteButton.className = "btn2";
    deleteButton.addEventListener("click", deleteRecord);
    actionCell.appendChild(deleteButton);
  }
}

// Function to add the form data to the table and update localStorage
function submitForm(event) {
  event.preventDefault();
  var form = document.getElementById("courseForm");
  var formData = new FormData(form);

  // Check the semester value
  var semester = formData.get("semester");
  if (semester == "0") {
    alert("Please select a semester.");
    return; // Exit the function
  }

  var rowData = [];
  formData.forEach(function (value) {
    rowData.push(value);
  });
  coursesData.push(rowData);
  localStorage.setItem("coursesData", JSON.stringify(coursesData));
  updateTable();
  form.reset();
}


// Function to delete a record from the table and update localStorage
function deleteRecord() {
  var rowIndex = parseInt(this.parentNode.parentNode.getAttribute("data-index"));
  coursesData.splice(rowIndex, 1);
  localStorage.setItem("coursesData", JSON.stringify(coursesData));
  updateTable();
}

// Function to edit a record in the table
function editRecord() {
  var rowIndex = parseInt(this.parentNode.parentNode.getAttribute("data-index"));
  var rowData = coursesData[rowIndex];

  var form = document.getElementById("courseForm");
  form.elements["deptName"].value = rowData[0];
  form.elements["semester"].value = rowData[1];
  form.elements["courseCode"].value = rowData[2];
  form.elements["courseName"].value = rowData[3];
  form.elements["credit"].value = rowData[4];
  form.elements["students"].value = rowData[5];

  coursesData.splice(rowIndex, 1);
  localStorage.setItem("coursesData", JSON.stringify(coursesData));
  updateTable();
}

// Function to clear the form and localStorage
function cancelForm() {
  var form = document.getElementById("courseForm");
  form.reset();
}

// Call the function to update the table when the page loads
window.addEventListener("load", updateTable);

// Event listener for the form submission
var form = document.getElementById("courseForm");
form.addEventListener("submit", submitForm);
