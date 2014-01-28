<?php
die('dsf');
require_once('SimpleImage.php');

$file_path = 'upload/'.$_FILES["file"]["name"];
$file = $_FILES['file'];
move_uploaded_file($_FILES["file"]["tmp_name"],  $file_path);

$image = new SimpleImage();
$image->load($file_path);

$width = $image->getWidth();
$height = $image->getHeight();
if($width > 150 ||  $height > 150) {
	$image->resize(150,150);
	$image->save($file_path); 
}
die($_FILES["file"]["name"]);
?>



