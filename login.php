<?php
/*
* This file handles the sign in form submission. 
* We take the password and compare the hash. 
* If the hash matches, we log the user in and create a session. 
* then redirect to home.php
*/

session_start();
// establish connection with db 
require_once 'utils.php';
$conn = create_db_connection();
// // sanitize username and password
$uname = strtolower(mysql_entities_fix_string($conn, $_POST['username']));
$upassword = mysql_entities_fix_string($conn, $_POST['password']);

// if there are no username or password provided to login page
if (!$uname && !$upassword) header("Location: index.php");

// use the username to query db 
$query = "SELECT * FROM Users WHERE username = '$uname'";
$result = $conn->query($query);
if (!$result) die($conn->error);

// No entry with the given username found
if ($result->num_rows === 0) {
  echo "Username incorrect";
  echo go_to_route_html('./index.php', 'Go back to try again');
  exit;
}

// hash the password
$salted_password = hash('ripemd128', $salt . $upassword);

// compare the hashes
$row = $result->fetch_row();
$is_authenticated = $salted_password === $row[1];

// if password checks out, create a session
if (!$is_authenticated) {
  echo "Nope! Password is incorrect";
  echo go_to_route_html('./index.php', 'Go back to try again');
  exit;
}

// The session is created
$_SESSION["username"]  = $uname;
echo "Login successful!";

// close db connection
mysqli_close($conn);

// redirect to home page.
header("Location: home.php");
