<?php
/*
* This file is the starting point for this project.
* User will see 2 forms. 1 to sign in and 1 to sign up. 
* on submitting those forms user is redirected to the connected php file.
*/
session_start();

//  in case the user is already logged in 
// redirect to home page
if ($_SESSION['username'] !== null) {
  header("Location: home.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Lame-Translate</title>
  <script>
    function validateLoginForm() {
      let username = document.forms["login-form"]["username"].value || '';
      let password = document.forms["login-form"]["password"].value || '';
      if (username.trim() == "") {
        alert("Please fill username.");
        return false;
      }
      if (password.trim() == "") {
        alert("Please fill password.");
        return false;
      }

      return true;
    }

    function validateSignupForm() {
      let username = document.forms["signup-form"]["username"].value || '';
      let password = document.forms["signup-form"]["password"].value || '';
      if (username.trim() == "") {
        alert("Please fill username.");
        return false;
      }
      if (password.trim() == "") {
        alert("Please fill password.");
        return false;
      }

      if (!/^[a-zA-Z]+$/.test(username)) {
        alert('Username can only include english letters.');
        return false;
      }

      return true;
    }
  </script>
</head>

<body>
  <h3>Login </h3>
  <form action="login.php" name="login-form" method="POST" enctyp="multipart/form-data" onsubmit="return validateLoginForm()">
    <label>Username</label>
    <input type="text" name="username" maxlength="30" />
    <br />
    <br />
    <label>Password</label>
    <input type="password" name="password" maxlength="30" />
    <br />
    <br />
    <button type="submit" name="submit">Login</button>
  </form>

  <hr />

  <h3>Signup </h3>
  <form action="sign_up.php" name="signup-form" method="POST" enctyp="multipart/form-data" onsubmit="return validateSignupForm()">
    <label>Username</label>
    <input type="text" name="username" maxlength="30" />
    <br />
    <br />
    <label>Password</label>
    <input type="password" name="password" maxlength="30" />
    <br />
    <br />
    <button type="submit" name="submit">Signup</button>
  </form>
</body>

</html>