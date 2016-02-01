<?php

define('IN_PHPATM', true);
include('include/conf.php');
include('include/functions.'.$phpExt);

$image = $_GET['image'];

$imagepath = clean_path("$uploads_folder_name/$image");

if (!file_exists($imagepath))
{
	header('Status: 404 Not Found');
	exit();
}

$mime_type = mime_type($image);

if ($mime_type != '')
{
	header("Content-type: $mime_type");
	header("Content-Disposition: attachment; filename=\"$image\"");
	@readfile($imagepath);
}
else
{
	header('Status: 404 Not Found');
}
?>
