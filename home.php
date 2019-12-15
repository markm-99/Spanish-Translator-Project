<?php
/*
* This file is the home page that the user sees after logging in. 
* Here the user can upload the dictionary or translate. Each action 
* redirects to the subsequent php file.
*/
session_start();

$username = $_SESSION["username"];
if (!$username) {
  header("Location: index.php");
}

echo 'Logged in as ' . $username;
echo '<br />';
echo '<br />';
echo <<<_END
<form action="upload.php" method="post" enctype="multipart/form-data">
    Select dictionary file to translate words ( .txt only ):
    <input type="file" name="dictionary_file" id="dictionary_file">
    <br />
    <input type="submit" value="Upload Files" name="submit">
</form>
<br />
<hr />
<br />
<form action="translate.php" method="post" enctype="multipart/form-data">
    Enter english words to translate
    <input type="text" name="words">
    <br />
    <input type="submit" value="Translate" name="submit">
</form>
<form action="logout.php" method="post" enctype="multipart/form-data">
<br /><br /><br />
    <input type="submit" value="logout" name="submit">
</form>
_END;
