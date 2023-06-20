<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login</title>
  <link rel="stylesheet" href="SignIn_style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet" />
</head>

<body>
  <div class="login-box">
    <h1>Login</h1>
    <form class="login-form" id="login-form">
      <label>Email</label>
      <input type="email" placeholder="" required autofocus />
      <label>Password</label>
      <input id="password" type="password" placeholder="" required minlength="8"/>
      <button type="reset" onclick="loginConfirm(event)">Log in</button>
      <closeform></closeform>
    </form>
  </div>
  <p class="para-2">
    No account? <a href="SignUp.php">Sign Up Here</a>
  </p>

  <script>
    function isFormComplete(form) {
      var fields = form.elements;

      for (var i = 0; i < fields.length; i++) {
        if (fields[i].required && fields[i].value === ""){
          return false;
        }
      }
      return true;
    }

    function isFormValid(form) {
      var fields = form.elements;

        if (! fields[0].checkValidity()){
          return false; 
      }
      return true;
    }

    function loginConfirm(event) {
      var form = document.getElementById("login-form");
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

      alert("Logged in successfully. Redirecting to homepage...");
      window.location.href = "Biblion.php";
      
    }

  </script>
</body>

</html>