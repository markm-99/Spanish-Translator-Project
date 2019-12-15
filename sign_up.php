<?php

/*
* This file handles the sign up form submmission.
*/

// establish connection with db 
require_once 'utils.php';
$conn = create_db_connection();

// sanitize username and password
$username = strtolower(mysql_entities_fix_string($conn, $_POST['username']));
$password = mysql_entities_fix_string($conn, $_POST['password']);

// create user
function add_user($connection, $username, $salted_password)
{
  $query = "INSERT INTO Users VALUES('$username', '$salted_password', null)";
  $result = $connection->query($query);
  if (!$result) die($connection->error);
}

// TODO: do some form validation eg ( duplicate username and empty fields );
if (check_user_exist($conn, $username)) {
  echo "Username is taken, try again.";
  echo go_to_route_html('./index.php', 'Go back');
  exit;
}


// salting password
$salted_password = hash('ripemd128', $salt . $password);

add_user($conn, $username, $salted_password);

// close db connection
mysqli_close($conn);

// tell user it went successfully 

echo "Sign Up Successful!";
echo <<<_END
<br />
<a href="./index.php">Go back to home to signin</a>
_END;
