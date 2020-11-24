<?php
	require("usesession.php");
	require("../../../config.php");
	require("fnc_common.php");
	
	//kui on idee sisestatud ja nuppu vajutatud, salvestame selle andmebaasi
	$database = "if20_morten_mu_3";
	if(isset($_POST["nonsensideasubmit"]) and !empty($_POST["nonsensideainput"])) {
		$conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
		$conn->set_charset("utf8");
		//valmistan ette sql käsu
		$stmt = $conn->prepare("INSERT INTO nonsens (nonsensidea) VALUES (?)");
		echo $conn->error; //ütleb kui on db error
		//seome käsuga päris andmed
		//i - integer, d - decimal, s - string
		$stmt->bind_param("s", test_input($_POST["nonsensideainput"]));
		$stmt->execute();
		echo $stmt->error;
		$stmt->close();
		$conn->close();
	}
	require("header.php");
?>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse banner">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <p><a href="?logout=1">Logi välja</a><p>
  <p><a href="home.php">Avalehele</a><p>
  <p><a href="listideas.php">Mõtete vaatamine</a><p>
  </ul> 
    <hr>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>Sisesta oma pähe tulnud mõte!</label>
	  <input type="text" name="ideainput" placeholder="Kirjuta siia mõte!">
	  <input type="submit" name="ideasubmit" value="Saada mõte ära!">
    </form>
  <hr>
</body>
</html>

