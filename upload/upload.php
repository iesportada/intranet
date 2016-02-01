<html>
<?php
$realname = $_FILES['userfile']['name'];
if(!empty($_FILES['userfile']['tmp_name'])) {

//copy the file to some permanent location
copy($_FILES['userfile']['tmp_name'], "$realname");
print $_FILES;
print $realname;
//destroy the file
unlink($userfile);

//display message
echo("file uploaded");
}
?>
</html>