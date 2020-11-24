<?php
	require("usesession.php");

	setcookie("vpvisitorname", $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"], time() + (86400 * 8), "/~mortmuh/", "greeny.cs.tlu.ee", isset($_SERVER["HTTPS"]), true);
	$lastvisitor = null;
	if(isset($_COOKIE["vpvisitorname"])) {
		$lastvisitor = "<p>Viimati külastas lehte: " .$_COOKIE["vpvisitorname"] .".</p> \n";
	} else {
		$lastvisitor = "<p>Küpsiseid ei leitud, viimane külastaja pole teada.</p> \n";
	}
	
	require("header.php");
?>


  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse banner">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <p><a href="?logout=1">Logi välja</a><p>
  
  <ul>
	<li><a href="listideas.php">Mõtete näitamine</a></li>
	<li><a href="addideas.php">Mõtete lisamine</a></li>
	
	<li><a href="listfilms.php">Filmiinfo näitamine</a></li>	
	<li><a href="addfilms.php">Filmide lisamine</a></li>
	<li><a href="addfilmrelations.php">Filmiandmete vahel seoste loomine</a></li>	
	<li><a href="addfilmdata.php">Filmiga seotud andmete lisamine</a></li>	
	<li><a href="showfilmdata.php">Filmiandmete kuvamise valikud</a></li>
	
	<li><a href="userprofile.php">Oma profiili haldamine</a></li>	
	<li><a href="photogallery_public.php">Avalike fotode galerii</a></li>
	<li><a href="photoupload.php">Piltide üleslaadimine</a></li>
  </ul> 
  <hr>
  <h3>Viimane külastaja sellest arvutist</h3>
  <?php
	if(count($_COOKIE > 0)) {
		echo "<p>Küpsised on lubatud! Leiti " .count($_COOKIE) ." küpsist.</p> \n";
	}
	echo $lastvisitor;
  ?>
</body>
</html>