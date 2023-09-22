// Function to get marks from local storage
function getMarksFromLocalStorage() {
    var marks = localStorage.getItem('marks');
    if (marks) {
        return JSON.parse(marks);
    } else {
        return [];
    }
}

// Function to save marks to local storage
function saveMarksToLocalStorage(marks) {
    localStorage.setItem('marks', JSON.stringify(marks));
}

// Function to render the marks table
function renderMarksTable() {
    var marks = getMarksFromLocalStorage();
    var tableBody = document.getElementById('marksTableBody');
    tableBody.innerHTML = '';

    for (var i = 0; i < marks.length; i++) {
        var mark = marks[i];

        // Calculate the grade
        var totalGrade = calculateTotalGrade(mark.ct1Marks, mark.ct2Marks, mark.ct3Marks, mark.attendanceMarks, mark.finalMarks);

        var row = document.createElement('tr');
        row.innerHTML = '<td>' + mark.studentID + '</td>' +
            '<td>' + mark.courseCode + '</td>' +
            '<td>' + mark.ct1Marks + '</td>' +
            '<td>' + mark.ct2Marks + '</td>' +
            '<td>' + mark.ct3Marks + '</td>' +
            '<td>' + mark.attendanceMarks + '</td>' +
            '<td>' + mark.finalMarks + '</td>' +
            '<td>' + totalGrade + '</td>' +  // Add the total grade here
            '<td class="actions-cell">' +
            '<button onclick="editMark(' + i + ')">Edit</button>' +
            '<button onclick="deleteMark(' + i + ')">Delete</button>' +
            '</td>';

        tableBody.appendChild(row);
    }
}


//Calculate total grade
function calculateTotalGrade(ct1, ct2, ct3, attendance, final) {
    // Calculate the average of the best 2 CT marks
    var ctMarks = [ct1, ct2, ct3];
    ctMarks.sort(function (a, b) {
        return b - a;
    });
    var avgCTMarks = (ctMarks[0] + ctMarks[1]) / 2;

    // Calculate the total grade by adding CT marks, attendance marks, and final marks
    var totalGrade = avgCTMarks + attendance + final;

    if (totalGrade >= 80) {
        return 4.00
    } else if (totalGrade >= 75 && totalGrade < 80) {
        return 3.75
    } else if (totalGrade >= 70 && totalGrade < 75) {
        return 3.50
    } else if (totalGrade >= 65 && totalGrade < 70) {
        return 3.25
    } else if (totalGrade >= 60 && totalGrade < 65) {
        return 3.00
    } else if (totalGrade >= 55 && totalGrade < 60) {
        return 2.75
    } else if (totalGrade >= 50 && totalGrade < 55) {
        return 2.50
    } else if (totalGrade >= 45 && totalGrade < 50) {
        return 2.25
    } else if (totalGrade >= 40 && totalGrade < 45) {
        return 2.00
    }
    return Fail;
}

// Function to add a mark
function addMark() {
    var studentID = parseInt(document.getElementById('studentIDInput').value);
    var courseCode = parseInt(document.getElementById('courseCodeInput').value);
    var ct1Marks = parseInt(document.getElementById('ct1MarksInput').value);
    var ct2Marks = parseInt(document.getElementById('ct2MarksInput').value);
    var ct3Marks = parseInt(document.getElementById('ct3MarksInput').value);
    var attendanceMarks = parseInt(document.getElementById('attendanceMarksInput').value);
    var finalMarks = parseInt(document.getElementById('finalMarksInput').value);

    var totalGrade = calculateTotalGrade(ct1Marks, ct2Marks, ct3Marks, attendanceMarks, finalMarks);


    var mark = {
        studentID: studentID,
        courseCode: courseCode,
        ct1Marks: ct1Marks,
        ct2Marks: ct2Marks,
        ct3Marks: ct3Marks,
        attendanceMarks: attendanceMarks,
        finalMarks: totalGrade
    };

    var marks = getMarksFromLocalStorage();
    marks.push(mark);
    saveMarksToLocalStorage(marks);
    renderMarksTable();
    resetForm();
}

// Function to delete a mark
function deleteMark(index) {
    var marks = getMarksFromLocalStorage();
    marks.splice(index, 1);
    saveMarksToLocalStorage(marks);
    renderMarksTable();
}

// Function to edit a mark
function editMark(index) {
    var marks = getMarksFromLocalStorage();
    var mark = marks[index];

    document.getElementById('studentIDInput').value = mark.studentID;
    document.getElementById('courseCodeInput').value = mark.courseCode;
    document.getElementById('ct1MarksInput').value = mark.ct1Marks;
    document.getElementById('ct2MarksInput').value = mark.ct2Marks;
    document.getElementById('ct3MarksInput').value = mark.ct3Marks;
    document.getElementById('attendanceMarksInput').value = mark.attendanceMarks;
    document.getElementById('finalMarksInput').value = mark.finalMarks;

    // Delete the existing mark and save the updated mark
    marks.splice(index, 1);
    saveMarksToLocalStorage(marks);

    var submitButton = document.getElementsByClassName('submit-button')[0];
    submitButton.innerHTML = 'Update';
    submitButton.onclick = function () {
        updateMark(index);
    };
}

// Function to update a mark
function updateMark(index) {
    var studentID = parseInt(document.getElementById('studentIDInput').value);
    var courseCode = parseInt(document.getElementById('courseCodeInput').value);
    var ct1Marks = parseInt(document.getElementById('ct1MarksInput').value);
    var ct2Marks = parseInt(document.getElementById('ct2MarksInput').value);
    var ct3Marks = parseInt(document.getElementById('ct3MarksInput').value);
    var attendanceMarks = parseInt(document.getElementById('attendanceMarksInput').value);
    var finalMarks = parseInt(document.getElementById('finalMarksInput').value);

    var totalGrade = calculateTotalGrade(ct1Marks, ct2Marks, ct3Marks, attendanceMarks, finalMarks);

    var mark = {
        studentID: studentID,
        courseCode: courseCode,
        ct1Marks: ct1Marks,
        ct2Marks: ct2Marks,
        ct3Marks: ct3Marks,
        attendanceMarks: attendanceMarks,
        finalMarks: totalGrade
    };

    var marks = getMarksFromLocalStorage();
    marks.splice(index, 0, mark);
    saveMarksToLocalStorage(marks);
    renderMarksTable();
    resetForm();
}

// Function to reset the form
function resetForm() {
    document.getElementById('studentIDInput').value = '';
    document.getElementById('courseCodeInput').value = '';
    document.getElementById('ct1MarksInput').value = '';
    document.getElementById('ct2MarksInput').value = '';
    document.getElementById('ct3MarksInput').value = '';
    document.getElementById('attendanceMarksInput').value = '';
    document.getElementById('finalMarksInput').value = '';

    var submitButton = document.getElementsByClassName('submit-button')[0];
    submitButton.innerHTML = 'Submit';
    submitButton.onclick = addMark;
}

// Event listener for the cancel button
var cancelButton = document.getElementById('cancel-button');
cancelButton.addEventListener('click', resetForm);

// Function to download the table as a PDF
function downloadTable() {
    // Get the table element
    var table = document.getElementById("marksTable");

    // Clone the table element to avoid modifying the original table
    var clonedTable = table.cloneNode(true);

    // Set the width style of the cloned table to ensure it fits within the PDF
    clonedTable.style.width = "100%";

    // Create a new div element to hold the cloned table
    var div = document.createElement("div");
    div.appendChild(clonedTable);

    // Generate the PDF using html2pdf.js
    html2pdf().from(div).save("student_marks.pdf");
}



// Event listener for form submission
var submitButton = document.getElementsByClassName('submit-button')[0];
submitButton.onclick = addMark;

// Render the marks table on page load
renderMarksTable();



function downloadTable() {
    var table = document.getElementById("marksTable");
    var clonedTable = table.cloneNode(true);
    clonedTable.style.width = "100%";
    var div = document.createElement("div");
    div.appendChild(clonedTable);
    html2pdf().from(div).save("student_marks.pdf");
}