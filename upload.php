<?php
session_start();
?>

<?php
require_once 'constants.php';
require_once 'utils.php';

$uname = $_SESSION["username"];

if (!$uname) {
  echo "You are not logged in.";
  exit;
}

$upload_name = "dictionary_file";

$target_file = $target_dir . basename($_FILES[$upload_name]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// check for file type
if ($imageFileType != "txt") {
  echo "Sorry, only .txt files are allowed.";
  exit;
}

// read file
$fp = fopen($_FILES[$upload_name]['tmp_name'], 'rb');

$dictionary = array();

// parsing uploaded file
while (($line = fgets($fp)) !== false) {
  // TODO: if there is any isses with file parsing
  // user provided the wrong format
  // let the user know that they messed up.
  $line = filter_var($line, FILTER_SANITIZE_STRING);
  $line = trim($line);
  $english_word = trim(explode(',', $line)[0]);
  $language_word = trim(explode(',', $line)[1]);
  $dictionary[$english_word] = $language_word;
}

// establish connection with db 
$conn = mysqli_connect($host_name, $username, $password, $db);
if (!$conn) {
  die("connection failed " . mysqli_connect_error());
}

$serialized_dictionary = serialize($dictionary);
// Add user provided dictionary to db
$query = "UPDATE Users SET translate_dictionary = '$serialized_dictionary' WHERE username = '$uname'";
$result = $conn->query($query);
if (!$result) die($conn->error);

echo "Dictionary successfully uploaded!";
echo <<<_END
<br />
<a href="./home.php">Go back to translate.</a>
_END;

// close db connection 
mysqli_close($conn);
