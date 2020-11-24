<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>Veebileht</title>
  <style>
<?php
echo "body {";
if(isset($_SESSION["bgcolor"])){
	echo "background-color: " .$_SESSION["bgcolor"]. ";";
} else {
	echo "background-color: #FFFFFF;";
}
if(isset($_SESSION["txtcolor"])){
	echo "color: " .$_SESSION["txtcolor"];
}
echo "}";
?>
</style>
</head>
<body>