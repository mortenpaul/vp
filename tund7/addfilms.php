
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
  //kui klikiti nuppu siis kontrollime ja salvestame
  $inputerror = "";
  if(isset($_POST["filmsubmit"])){
	if(empty($_POST["titleinput"]) or empty($_POST["genreinput"]) or empty($_POST["studioinput"]) or empty($_POST["directorinput"])){
		$inputerror .= "Osa vajalikku infot on sisestamata! ";
	}
	if($_POST["yearinput"] > date("Y") or $_POST["yearinput"]  < 1895) {
		$inputerror .= "Ebareaalne valmimisaasta!";
	}
	if(empty($inputerror)){
		writefilm($_POST["titleinput"], $_POST["yearinput"], $_POST["durationinput"], $_POST["genreinput"], $_POST["studioinput"], $_POST["directorinput"]);
	}
  }

  require("header.php");
?>

	<img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse banner">
	<h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?> programmeerib veebi</h1>
	<p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
	<p><a href="?logout=1">Logi välja</a><p>
	<a href="home.php">Avaleht</a>
	<a href="listfilms.php">Filmide info</a>
	<hr>
	<form method="POST">
	<label for="titleinput">Filmi pealkiri: </label>
	<input type="text" name="titleinput" id="titleinput" placeholder="pealkiri">
	<br>
	<label for="yearinput">Filmi valmimisaasta: </label>
	<input type="number" name="yearinput" id="yearinput" value="<?php echo date("Y"); ?>">
	<br>
	<label for="durationinput">Filmi kestvus minutites: </label>
	<input type="number" name="durationinput" id="durationinput" value="80">
	<br>
	<label for="genreinput">Filmi žanr: </label>
	<input type="text" name="genreinput" id="genreinput" placeholder="žanr">
	<br>
	<label for="studioinput">Filmi Tootja: </label>
	<input type="text" name="studioinput" id="studioinput" placeholder="stuudio">
	<br>
	<label for="directorinput">Filmi Lavastaja: </label>
	<input type="text" name="directorinput" id="directorinput" placeholder="lavastaja">
	<br>
	<input type="submit" name="filmsubmit" value="Salvesta filmiinfo">
  </form>
  </p><? php echo $inputerror; ?></p>
</body>
</html>

