<?php

	$url = $_GET["url"];
	$file = urldecode($url);
	$file = str_replace(" ","%20",$file);
	
	$what = getimagesize($file);
	switch(strtolower($what['mime'])) {
		case 'image/png':
			$img = imagecreatefrompng($file);
			break;
		case 'image/jpeg':
			$img = imagecreatefromjpeg($file);
			break;
		case 'image/gif':
			$img = imagecreatefromgif($file);
			break;
		default: die();
	}

	$new = imagecreatetruecolor($what[0],$what[1]);
	imagecopy($new,$img,0,0,0,0,$what[0],$what[1]);

	header('Content-Type: image/jpeg');
	imagejpeg($new);
	imagedestroy($new);

?>