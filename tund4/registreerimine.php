  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1>Morten-Paul programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  
  <a href="home.php">Avaleht</a>
  <hr>
  
 <?php
  //loeme andmebaasi login ifo muutujad
  require("../../../config.php");
  
	  $monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
  	$firstnameerror = "";
	$lastnameerror = "";
	$gendererror = "";
	$emailerror = "";
	$passworderror = "";
	$passwordsecondaryerror = "";
	
	$firstname = "";
	$lastname = "";
	$gender = "";
	$email = "";
	
	if(empty($_POST["firstnameinput"]) and !empty($_POST["accountdatasubmit"])) {
	$firstnameerror = "Eesnimi sisestamata!";
	$lastname = $_POST["lastnameinput"]; $email = $_POST["emailinput"];
	}
	if(empty($_POST["lastnameinput"]) and !empty($_POST["accountdatasubmit"])) {
		$lastnameerror = "Perekonnanimi sisestamata!";
		$firstname = $_POST["firstnameinput"]; $email = $_POST["emailinput"];
	}
	if(empty($_POST["genderinput"]) and !empty($_POST["accountdatasubmit"])) {
		$gendererror = "Sugu valimata!";
		$firstname = $_POST["firstnameinput"]; $lastname = $_POST["lastnameinput"]; $email = $_POST["emailinput"];
	}
	if(empty($_POST["emailinput"]) and !empty($_POST["accountdatasubmit"])) {
		$emailerror = "E-post sisestamata!";
		$firstname = $_POST["firstnameinput"]; $lastname = $_POST["lastnameinput"];
	}
	if(empty($_POST["passwordinput"]) and !empty($_POST["accountdatasubmit"])) {
		$passworderror = "Salasõna sisestamata!";
		$passwordsecondaryerror = "Salasõna sisestamata!";
		$firstname = $_POST["firstnameinput"]; $lastname = $_POST["lastnameinput"]; $email = $_POST["emailinput"];
	} elseif(empty($_POST["passwordsecondaryinput"]) and !empty($_POST["accountdatasubmit"]) and empty($passworderror)) {
		$passwordsecondaryerror = "Salasõna tuleb ka teist korda sisestada!";
		$firstname = $_POST["firstnameinput"]; $lastname = $_POST["lastnameinput"]; $email = $_POST["emailinput"];
	} elseif(!empty($_POST["accountdatasubmit"]) and ((strlen($_POST["passwordinput"]) < 8) or (strlen($_POST["passwordsecondaryinput"]) < 8))) {
		$passworderror = "Salasõna peab olema vähemalt 8 tähemärki pikk!";
		$passwordsecondaryerror = "Salasõna peab olema vähemalt 8 tähemärki pikk!";
		$firstname = $_POST["firstnameinput"]; $lastname = $_POST["lastnameinput"]; $gender = $_POST["genderinput"]; $email = $_POST["emailinput"];
	} elseif(!empty($_POST["accountdatasubmit"]) and ($_POST["passwordinput"] != $_POST["passwordsecondaryinput"])) {
		$passworderror = "Salasõnad ei ühti!";
		$passwordsecondaryerror = "Salasõnad ei ühti!";
		$firstname = $_POST["firstnameinput"]; $lastname = $_POST["lastnameinput"]; $gender = $_POST["genderinput"]; $email = $_POST["emailinput"];
	} else {
		;
	}
	
?>
 
   <form method="POST">
	  <label for="firstnameinput">Eesnimi:</label>
	  <input type="text" name="firstnameinput" id="firstnameinput" value="<?php echo $firstname; ?>">
	  <span><?php echo $firstnameerror; ?></span>
	  <br>
	  <label for="lastnameinput">Perekonnanimi:</label>
	  <input type="text" name="lastnameinput" id="lastnameinput" value="<?php echo $lastname; ?>">
	  <span><?php echo $lastnameerror; ?></span>
	  <br>
	  <label for="genderinput">Sugu:</label>
	  <input type="radio" name="genderinput" id="gendermale" value="1" <?php if($gender == "1"){echo "checked";} ?>><label for="gendermale">Mees</label><input type="radio" name="genderinput" id="genderfemale" value="2" <?php if($gender == "2"){echo "checked";} ?>><label for="genderfemale">Naine</label>
	  <span><?php echo $gendererror; ?></span>
	  <br>
	  <label for="emailinput">E-posti aadress:</label>
	  <input type="email" name="emailinput" id="emailinput" value="<?php echo $email; ?>">
	  <span><?php echo $emailerror; ?></span>
	  <br>
	  <label for="passwordinput">Salasõna:</label>
	  <input type="password" name="passwordinput" id="passwordinput">
	  <span><?php echo $passworderror; ?></span>
	  <br>
	  <label for="passwordsecondaryinput">Salasõna uuesti:</label>
	  <input type="password" name="passwordsecondaryinput" id="passwordsecondaryinput">
	  <span><?php echo $passwordsecondaryerror; ?></span>
	  <br>
	  <input type="submit" name="accountdatasubmit" value="Registreeri">
    </form>
	<hr>

</body>
</html>