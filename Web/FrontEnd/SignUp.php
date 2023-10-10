<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Sign Up</title>
  <link rel="stylesheet" href="../CSS/SignIn_style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <div class="signup-box">
    <h1>Sign Up</h1>
    <form id="signup-form">
      <label>Username</label>
      <input id="username" type="text" placeholder="" autocomplete="off" required autofocus />
      <label>Email</label>
      <input id="email" type="email" placeholder="" autocomplete="off" required />
      <label>Password</label>
      <input id="password" type="password" placeholder="" autocomplete="off" required minlength="8" />
      <label>Confirm Password</label>
      <input id="confirmpass" type="password" placeholder="" required />
      <button type="reset" onclick="signupConfirm(event)">Submit</button>
    </form>
    <p class="para">
      Already have an account? <a href="SignIn.php">Login here</a>
    </p>
  </div>

  <script>
    function isFormComplete(form) {
      var fields = form.elements;

      for (var i = 0; i < fields.length; i++) {
        if (fields[i].required && fields[i].value === "") {
          return false;
        }
      }
      return true;
    }

    function isPasswordMatching() {
      var password = document.getElementById("password").value;
      var confirmPassword = document.getElementById("confirmpass").value;
      if (confirmPassword === password) {
        return true;
      }
      return false;
    }


    function isFormValid() {
      var email = document.getElementById("email").value;
      var emailRegex = /^\S+@\S+\.\S+$/;

      return emailRegex.test(email);
    }

    function signupConfirm(event) {
      var username = document.getElementById("username").value;
      var email = document.getElementById("email").value;
      var form = document.getElementById("signup-form");
      var password = document.getElementById("password").value;
      event.preventDefault();

      if (!isFormComplete(form)) {
        alert("Please fill in all required fields.");
        return;
      }

      if (!isFormValid(form)) {
        alert("Please enter a valid e-mail address");
        return;
      }

      if (password.length < 8) {
        alert("Password must be atleast 8 characters long");
        return;
      }

      if (!isPasswordMatching()) {
        alert("Passwords don't match");
        return;
      }

      var formData = {
        username: username,
        email: email,
        password: password,
      };

      $.ajax({
        type: "POST",
        url: "../BackEnd/backend_signup.php",
        data: formData,
        success: function (response) {
          if (response === "success") {
            window.location.href = document.referrer;
          } else if (response === "duplicate") {
            alert("Username or email already in use.");
          } else {
            alert("Error occurred while registering. Please try again.");
          }
        },
        error: function (xhr, status, error) {
          console.log(error);
          alert("An error occurred while processing your request. Please try again later.");
        },
      });
    }
  </script>
</body>

</html>