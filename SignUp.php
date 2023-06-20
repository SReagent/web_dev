<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="SignIn_style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet"/>
  </head>
  <body>
    <div class="signup-box">
      <h1>Sign Up</h1>
      <form id="signup-form">
        <label>First Name</label>
        <input type="text" placeholder="" required autofocus />
        <label>Last Name</label>
        <input type="text" placeholder="" />
        <label>Email</label>
        <input type="email" placeholder=""  required/>
        <label>Password</label>
        <input id="password" type="password" placeholder="" required minlength="8"/>
        <label>Confirm Password</label>
        <input id="confirmpass" type="password" placeholder="" required/>
        <button type="reset" onclick="signupConfirm(event)">Submit</button>
      <closeform></closeform></form>
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
      if(confirmPassword===password){
        return true;
      }
      return false;
    }

    function isFormValid(form) {
      var fields = form.elements;

        if (! fields[2].checkValidity()){
          return false;
      }
      return true;
    }

    function signupConfirm(event) {
      var form = document.getElementById("signup-form");
      var password = document.getElementById("password").value;
      event.preventDefault();

      if(! isFormComplete(form)){
        alert("Please fill in all required fields.");
        return;
      } 

      if(! isFormValid(form)){
        alert("Please enter a valid e-mail address");
        return;
      }

      if(password.length < 8){
        alert("Password must be atleast 8 characters long");
        return;
      }

      if(! isPasswordMatching()){
        alert("Passwords don't match");
        return;
      }

      alert("Signed Up successfully. Redirecting to homepage...");
      window.location.href = "Biblion.php";
    }

    </script>
  </body>
  
</html>