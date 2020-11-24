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
  //kui kasutaja on vormis andmeid saatnud, siis salvestame andmebaasi
  $database = "if20_morten_mu_3";
    
  //loeme andmebaasist
  $nonsenshtml = "";
  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
  //valmistame ette SQL käsu
  $stmt = $conn->prepare("SELECT nonsensidea FROM nonsens");
  echo $conn->error;
  //seome tulemuse mingi muutujaga
  $stmt->bind_result($nonsensfromdb);
  $stmt->execute();
  //võtan, kuni on
  while($stmt->fetch()){
	  //<p>suvaline mõte </p>
	  $nonsenshtml .= "<p>" .$nonsensfromdb ."</p>";
  }
  $stmt->close();
  $conn->close();
  //ongi andmebaasisit loetud


  require("header.php");
?>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse banner">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <p>See rida on tehtud kodus, mu enda arvutis.</p>
  <p><a href="?logout=1">Logi välja</a><p>
  
  <ul>
	<li><a href="listideas.php">Mõtete näitamine</a> | <a href="addideas.php">Mõtete lisamine</a></p>
	<li><a href="addideas.php">Mõtete lisamine</a></li>
	<li><a href="listfilms.php">Filmiinfo näitamine</a></li>	
	<li><a href="addfilms.php">Filmide lisamine</a></li>
	<li><a href="registreerimine.php">Kasutaja loomine</a></li>	
  </ul> 

</body>
</html>
