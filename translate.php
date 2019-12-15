<?php
/*
* This file handles the translate form submission.
* uses the user provided dictionary to map input words to the dictionary words.
*/

require_once 'utils.php';
session_start();
// check if user logged in 
$username = $_SESSION["username"];
if (!$username) header("Location: index.php");

//  getting the string entered by user
$input_string = filter_var($_POST['words'], FILTER_SANITIZE_STRING);
$input_string_into_words = explode(' ', $input_string);

// getting user provided dictionary from db
$conn = create_db_connection();
$query = "SELECT * FROM Users WHERE username = '$username'";
$result = $conn->query($query);

if (!$result) die($conn->error);

$row = $result->fetch_row();

// default model ( if the user doesn't provide their own )
$dictionary = get_default_model();
$serialized_dict = $row[2];
if ($serialized_dict !== null) {
  $dictionary = unserialize($row[2]);
}

$translated_string = '';

// Using the dictionary to create translated string.
// Current limitation is that if the user uses punctuation like , or . 
// that will be considered a different word hence the mapping won't 
// work for that particular word
foreach ($input_string_into_words as $word) {
  $word = strtolower($word);
  if ($dictionary[$word] !== null) {
    $translated_string .= $dictionary[$word] . ' ';
  } else {
    $translated_string .= $word . ' ';
  }
}

echo 'Input String : ' . $input_string;
echo "<br />";
echo 'Translation : ' . $translated_string;

// close db connection 
mysqli_close($conn);
