function submitForm(event) {
  event.preventDefault();
  var form = document.getElementById("myForm");
  var formData = new FormData(form);
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "tahsinahmed.iit@gmail.com", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      alert("Form submitted successfully!");
      form.reset();
    } else {
      alert("Form submission failed. Please try again later.");
    }
  };
  xhr.send(formData);
}

function cancelForm() {
  var form = document.getElementById("myForm");
  form.reset();
}
