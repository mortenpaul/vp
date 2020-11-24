<?php
  session_start();
  
  //kui pole sisseloginud
  if(!isset($_SESSION["userid"])){
	  //jõugu sisselogimise lehele
	  header("Location: page.php");
  }
  //väljalogimine
  if(isset($_GET["logout"])){
	  session_destroy();
	   header("Location: page.php");
	   exit();
  }
  //loeme andmebaasi login ifo muutujad
  require("../../../config.php");
  


  $sortby = 0;
  $sortorder = 0;

require("fnc_film.php");
  require("header.php");
?>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse banner">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <p><a href="?logout=1">Logi välja</a><p>
  <p><a href="home.php">Avaleht</a><p>
  </ul>
  
<h2>Filmitegelased:</h2>
  <?php
	if(isset($_GET["sortby"]) and isset($_GET["sortorder"])) {
		if($_GET["sortby"] >= 1 and $_GET["sortby"] <= 4) {
			$sortby = $_GET["sortby"];
		}
		if($_GET["sortorder"] == 1 or $_GET["sortorder"] == 2) {
			$sortorder = $_GET["sortorder"];
		}
	}
	echo readpersonsinfilm($sortby, $sortorder);
  ?>
  <hr>
</body>
</html>

