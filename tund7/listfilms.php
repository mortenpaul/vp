
<?php
session_start();
	
  //kui pole sisseloginud
  if(!isset($_SESSION["userid"])){
	//jõuga sisselogimise lehele
	header("location: page.php");
  }

  if(isset($_GET["logout"])){
	  session_destroy();
	  header("location: page.php");
	  exit();
  }
  //loeme andmebaasi login ifo muutujad
  require("../../../config.php");
  require("fnc_film.php");


  require("header.php");
?>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse banner">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <p><a href="?logout=1">Logi välja</a><p>
  <p><a href="home.php">Avalehele</a><p>
  </ul> 
   <?php echo readfilms(); ?>

</body>
</html>
