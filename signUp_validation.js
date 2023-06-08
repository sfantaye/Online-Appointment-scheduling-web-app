document.addEventListener('DOMContentLoaded', function() {
  var form = document.getElementById('signupForm');
  var signupButton = document.getElementById('signupButton');

  signupButton.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default link behavior

    // Perform form validation
    var name = document.getElementById('name').value;
    var username = document.getElementById('username').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirmPassword').value;
     // Validate username
     if (name === '') {
      alert('Please enter a username.');
      return;
    }


    // Validate username
    if (username === '') {
      alert('Please enter a username.');
      return;
    }

    // Validate email
    if (email === '') {
      alert('Please enter an email address.');
      return;
    }

    // Validate password
    if (password === '') {
      alert('Please enter a password.');
      return;
    }

    // Validate confirm password
    if (confirmPassword === '') {
      alert('Please confirm your password.');
      return;
    }

    if (password !== confirmPassword) {
      alert('Passwords do not match.');
      return;
    }

    // If all validations pass, submit the form
    form.submit();
  });
});
