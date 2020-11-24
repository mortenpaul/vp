<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>Veebileht</title>

  <?php
	if(isset($tolink)) {
		echo $tolink;
	}
  ?>
  
  <style>
  <?php
	echo "\t body { \n";
	if(isset($_SESSION["userbgcolor"])) {
		echo "\t \t background-color: " .$_SESSION["userbgcolor"] ."; \n";
	} else {
		echo "\t \t background-color: mintcream; \n";	
	}
	
	if(isset($_SESSION["usertxtcolor"])) {
		echo "\t \t color: " .$_SESSION["usertxtcolor"] ."; \n";
	} else {
		echo "\t \t color: #000000; \n";
	}
	echo "\t \t } \n";
  ?>
  </style>
  
 
  <meta charset="UTF-8">
</head>
<link rel="icon" href="../img/vp_logo_small.png">
<body>