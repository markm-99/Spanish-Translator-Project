<?php
function mysql_entities_fix_string($conn, $string)
{
  return htmlentities(mysql_fix_string($conn, $string));
}

function mysql_fix_string($conn, $string)
{
  if (get_magic_quotes_gpc()) $string = stripslashes($string);
  return $conn->real_escape_string($string);
}

function sanitizeString($var)
{
  $var = stripslashes($var);
  $var = strip_tags($var);
  $var = htmlentities($var);
  return $var;
}

function sanitizeMySQL($connection, $var)
{
  $var = $connection->real_esacape_string($var);
  $var = sanitizeString($var);
  return $var;
}

function check_user_exist($connection, $username)
{
  $query = "SELECT * FROM Users WHERE username = '$username'";
  $result = $connection->query($query);
  if (!$result) die($connection->error);

  return $result->num_rows > 0;
}


function go_to_route_html($route, $description)
{
  return <<<_END
  <br />
  <a href="$route">$description</a>
_END;
}


function create_db_connection()
{
  require_once 'constants.php';
  $conn = mysqli_connect($host_name, $username, $password, $db);
  if (!$conn) {
    die("connection failed " . mysqli_connect_error());
  }
  return $conn;
}


function get_default_model()
{
  return array(
    "welcome" => "denada",
    "yes" => "si",
    "maybe" => "tal vez",
    'hello' => 'hola',
    "banana" => "plátano",
    "night" => "noches",
    "name" => "nombre",
    "never" => "nunca",
    "good" => "buenos",
    "how" => "como",
    "morning" => "dias",
    "always" => "siempre",
    "is" => "es",
    "happening" => "pasa",
    "doing" => "haces",
    "hi" => "hola",
    "my" => "mi",
  );
}
