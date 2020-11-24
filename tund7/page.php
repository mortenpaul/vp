<?php
	session_start();
	//var_dump($_POST); post input väärtused, premade array
	require("../../../config.php");
	require("fnc_user.php");
	require("fnc_common.php");
	
	
	//loeme andmebaasi login info muutujad
	$username = "Morten-Paul";
	$fulltimenow = date("d.m.Y H:i:s");
	$hournow = date("H");
	$partofday = "lihtsalt aeg";
	
	//vaatame mida formist lehele saadetakse
	//var_dump($_POST);
	
	$weekdaynameset = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
	$monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	
	//küsime nädalapäeva
	$weekdaynow = date("N");
	//echo $weekdaynow
	
	if($hournow < 6){
		$partofday = "uneaeg";
	}
	if($hournow >= 6 and $hournow < 8){
		$partofday = "hommikuste protseduuride aeg";
		
	}
	if($hournow >= 6 and $hournow < 18){
		$partofday = "õppimise aeg";
		
	}
	if($hournow >= 8 and $hournow < 18){
	  $partofday = "akadeemilise aktiivsuse aeg";
	  
	}
	if($hournow >= 18 and $hournow < 22){
	  $partofday = "õhtuste toimetuste aeg";
	  
	}
	if($hournow >= 22){
	  $partofday = "päeva kokkuvõtte ning magamamineku aeg";
	  
	}
		
	//jälgime semestri kulgu
	$semesterstart = new DateTime("2020-8-31");
	$semesterend = new DateTime("2020-12-13");
	$semesterduration = $semesterstart->diff($semesterend);
	$semesterdurationdays = $semesterduration->format("%r%a");
	$today = new DateTime("now");
	$fromsemesterstart = $semesterstart->diff($today);
	//saime aka  erinevuse objektina, seda niisama näidata ei saa
	$fromsemesterstartdays = $fromsemesterstart->format("%r%a");
	$semesterpercentage = 0;
  
  
  
	$semesterinfo = "Semester kulgeb vastavalt akadeemilisele kalendrile.";
	if($semesterstart > $today){
	  $semesterinfo = "Semester pole veel peale hakanud!";
	}
	if($fromsemesterstartdays === 0){
	  $semesterinfo = "Semester algab täna!";
	}
	if($fromsemesterstartdays > 0 and $fromsemesterstartdays < $semesterdurationdays){
	  $semesterpercentage = ($fromsemesterstartdays / $semesterdurationdays) * 100;
	  $semesterinfo = "Semester on täies hoos, kestab juba " .$fromsemesterstartdays ." päeva, läbitud on " .$semesterpercentage ."%.";
	}
	if($fromsemesterstartdays == $semesterdurationdays){
	  $semesterinfo = "Semester lõppeb täna!";
	}
	if($fromsemesterstartdays > $semesterdurationdays){
	  $semesterinfo = "Semester on läbi saanud!";
	}
	
	$allfiles = array_slice(scandir("../vp_pics/"), 2);
	$allpicfiles = [];
	$picfiletypes = ["image/jpeg", "image/png"];
	 foreach ($allfiles as $file){
		 $fileinfo = getImagesize("../vp_pics/" .$file);
		 if(in_array($fileinfo["mime"], $picfiletypes) == true){
			 array_push($allpicfiles, $file);
		 }
	 }
	
	//paneme kõik pildid järjest ekraanile
	//uurime, mitu pilti on ehk mitu faili on nimekirjas - massiivis
	$piccount = count($allpicfiles);
	$whichpic = mt_rand(0, ($piccount - 1));
	$imghtml = '<img src="../vp_pics/' .$allpicfiles[$whichpic] .'" alt="Tallinna Ülikool">';
	
  $email = "";
  
  $emailerror = "";
  $passworderror = "";
  $notice = "";
  if(isset($_POST["submituserdata"])){
	  if (!empty($_POST["emailinput"])){
		//$email = test_input($_POST["emailinput"]);
		$email = filter_var($_POST["emailinput"], FILTER_SANITIZE_EMAIL);
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$email = filter_var($email, FILTER_VALIDATE_EMAIL);
		} else {
		  $emailerror = "Palun sisesta õige kujuga e-postiaadress!";
		}		
	  } else {
		  $emailerror = "Palun sisesta e-postiaadress!";
	  }
	  
	  if (empty($_POST["passwordinput"])){
		$passworderror = "Palun sisesta salasõna!";
	  } else {
		  if(strlen($_POST["passwordinput"]) < 8){
			  $passworderror = "Liiga lühike salasõna (sisestasite ainult " .strlen($_POST["passwordinput"]) ." märki).";
		  }
	  }
	  
	  if(empty($emailerror) and empty($passworderror)){
		  $notice = signin($email, $_POST["passwordinput"]);
	  }
  }
	
	require("header.php");
?>


  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse banner">
  <h1>Äge veebisüsteem</h1>
  <p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  
  <ul>
	<li><a href="registreerimine.php">Kasutaja loomine</a></li>	
  </ul>
  
  <hr>
  <h3>Logi sisse</h3>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="emailinput">E-mail (kasutajatunnus):</label><br>
	  <input type="email" name="emailinput" id="emailinput" value="<?php echo $email; ?>"><span><?php echo $emailerror; ?></span>
	  <br>
	  <label for="passwordinput">Salasõna:</label>
	  <br>
	  <input name="passwordinput" id="passwordinput" type="password"><span><?php echo $passworderror; ?></span>
	  <br>
	  <br>
	  <input name="submituserdata" type="submit" value="Logi sisse"><span><?php echo "&nbsp; &nbsp; &nbsp;" .$notice; ?></span>
  </form>
  <hr>
  
  <p>Lehe avamise aeg: <?php echo $weekdaynameset[$weekdaynow - 1] .", " .$fulltimenow; ?>.
  <?php echo "Parajasti on " .$partofday ."."; ?></p>
  <p><?php echo $semesterinfo; ?></p>
  <hr>
  <?php echo $imghtml; ?>
  <hr>
  
  

</body>
</html>