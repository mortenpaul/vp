<?php
	require("usesession.php");
	require("../../../config.php");
	
	//loen lehele kõik olemasolevad mõtted
	$database = "if20_morten_mu_3";
	$conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
	$conn->set_charset("utf8");
	$stmt = $conn->prepare("SELECT nonsensidea FROM nonsens");
	echo $conn->error;
	//seome tulemuse muutujaga
	$stmt->bind_result($nonsensideafromdb);
	$stmt->execute();
	echo $stmt->error;
	$ideahtml = "";
	while($stmt->fetch()) {
		$ideahtml .= "<p>" .$nonsensideafromdb ."</p>";
	}
	$stmt->close();
	$conn->close();
	
	require("header.php");
?>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse banner">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <p><a href="?logout=1">Logi välja</a><p>
  <p><a href="home.php">Avaleht</a><p>
   <p><a href="addideas.php">Mõtete lisamine</a><p>
  <hr>
  <b>Kirja pandud mõtted (kõige alumised on kõige uuemad):</b>
  <?php echo $ideahtml; ?>
  <hr>

</body>
</html>
