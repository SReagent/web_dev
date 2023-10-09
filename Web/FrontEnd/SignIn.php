<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login</title>
  <link rel="stylesheet" href="../CSS/SignIn_style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <div class="login-box">
    <h1>Login</h1>
    <form class="login-form" id="login-form">
      <label>Email</label>
      <input id="email" type="email" placeholder="" autocomplete="off" required autofocus />
      <label>Password</label>
      <input id="password" type="password" placeholder="" autocomplete="off" required minlength="8" />
      <button type="reset" onclick="loginConfirm(event)">Log in</button>
    </form>
  </div>
  <p class="para-2">
    No account? <a href="SignUp.php">Sign Up Here</a>
  </p>

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

    function isFormValid(form) {
      var email = document.getElementById("email").value;
      var emailRegex = /^\S+@\S+\.\S+$/;

      return emailRegex.test(email);
    }

    function loginConfirm(event) {
      var email = document.getElementById("email").value;
      var form = document.getElementById("login-form");
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
      var formData = {
        email: email,
        password: password,
      };

      $.ajax({
        type: "POST",
        url: "../BackEnd/backend_signin.php",
        data: formData,
        success: function(response) {
          console.log(response);
          if (response === "success") {
            window.location.href = document.referrer;
          } else if (response === "error") {
            alert("Error occurred while logging in. Please try again.");
          } else if (response === "invalid") {
            alert("Invalid email or password.");
          }
        },
        error: function(xhr, status, error) {
          console.log(error);
          alert("An error occurred while processing your request. Please try again later.");
        },
      })

    }
  </script>
</body>

</html>