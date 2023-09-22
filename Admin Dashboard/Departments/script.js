// Check if there is any stored data in localStorage
var storedData = localStorage.getItem("Department");
var departmentsData = storedData ? JSON.parse(storedData) : [];

// Function to update the table with the stored data
function updateTable() {
  var table = document.getElementById("departmentsTable");
  var tbody = table.getElementsByTagName("tbody")[0];
  tbody.innerHTML = "";

  for (var i = 0; i < departmentsData.length; i++) {
    var rowData = departmentsData[i];
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
  var form = document.getElementById("myForm");
  var formData = new FormData(form);
  var rowData = [];
  formData.forEach(function (value) {
    rowData.push(value);
  });
  departmentsData.push(rowData);
  localStorage.setItem("departmentsData", JSON.stringify(departmentsData));
  updateTable();
  form.reset();
}

// Function to delete a record from the table and update localStorage
function deleteRecord() {
  var rowIndex = parseInt(this.parentNode.parentNode.getAttribute("data-index"));
  departmentsData.splice(rowIndex, 1);
  localStorage.setItem("departmentsData", JSON.stringify(departmentsData));
  updateTable();
}

// Function to edit a record in the table
function editRecord() {
  var rowIndex = parseInt(this.parentNode.parentNode.getAttribute("data-index"));
  var rowData = departmentsData[rowIndex];

  var form = document.getElementById("myForm");
  form.elements["departmentsCode"].value = rowData[0];
  form.elements["departmentsName"].value = rowData[1];
  form.elements["courses"].value = rowData[2];
  form.elements["semester"].value = rowData[3];
  form.elements["students"].value = rowData[4];
  form.elements["credit"].value = rowData[5];

  departmentsData.splice(rowIndex, 1);
  localStorage.setItem("departmentsData", JSON.stringify(departmentsData));
  updateTable();
}


// Function to clear the form and localStorage
function cancelForm() {
  var form = document.getElementById("myForm");
  form.reset();
}

// Call the function to update the table when the page loads
window.addEventListener("load", updateTable);

// Event listener for the form submission
var form = document.getElementById("myForm");
form.addEventListener("submit", submitForm);
