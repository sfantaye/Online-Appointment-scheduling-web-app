document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('loginForm');
    var loginButton = document.getElementById('loginButton');
  
    loginButton.addEventListener('click', function(event) {
      event.preventDefault(); // Prevent the default link behavior
  
      // Perform form validation
      var username = document.getElementById('username').value;
      var password = document.getElementById('password').value;
     
  
      // Validate username
      if (username === '') {
        alert('Please enter a username.');
        return;
      }
  
      // Validate password
      if (password === '') {
        alert('Please enter a password.');
        return;
      }
      // If all validations pass, submit the form
      form.submit();
    });
  });
  