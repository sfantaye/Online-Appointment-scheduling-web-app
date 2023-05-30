function validateForm() {
    var nameInput = document.getElementById("name");
    var emailInput = document.getElementById("email");
    var phoneInput = document.getElementById("phone");
    var dateInput = document.getElementById("date");
    var timeInput = document.getElementById("time");

    if (nameInput.value === "") {
      alert("Please enter your name.");
      nameInput.focus();
      return false;
    }

    if (emailInput.value === "") {
      alert("Please enter your email.");
      emailInput.focus();
      return false;
    }

    if (phoneInput.value === "") {
      alert("Please enter your phone number.");
      phoneInput.focus();
      return false;
    }

    if (dateInput.value === "") {
      alert("Please enter a preferred date.");
      dateInput.focus();
      return false;
    }

    if (timeInput.value === "") {
      alert("Please enter a preferred time.");
      timeInput.focus();
      return false;
    }

    return true;
  }