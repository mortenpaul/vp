<?php
	$database = "if20_morten_mu_3";

	function signup($firstname, $lastname, $email, $gender, $birthdate, $password){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("INSERT INTO vpusers (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)");
		echo $conn->error;
		
		//krüpteerime parooli
		$options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
		$pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
		
		$stmt->bind_param("sssiss", $firstname, $lastname, $birthdate, $gender, $email, $pwdhash);
		if($stmt->execute()){
			$notice = "ok";
		} else {
			$notice = $stmt->error;
		}
		$stmt->close();
	    $conn->close();
		return $notice;
	}
	
	function signin($email, $password){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT password FROM vpusers WHERE email = ?");
		echo $conn->error;
		$stmt->bind_param("s", $email);
		$stmt->bind_result($passwordfromdb);
		if($stmt->execute()){
			//andmebaasi päring õnnestus
			if($stmt->fetch()){
				if(password_verify($password, $passwordfromdb)){
					//mis kõik teha, kui saigi õige parooli, sisselogimine
					$notice = "ok";
					$stmt->close();
					
					$stmt = $conn->prepare("SELECT vpusers_id, firstname, lastname FROM vpusers WHERE email = ?");
					echo $conn->error;
					$stmt->bind_param("s", $email);
					$stmt->bind_result($idfromdb, $firstnamefromdb, $lastnamefromdb);
					$stmt->execute();
					$stmt->fetch();
					//omistan loetud väärtused sessioonimuutujatele
					$_SESSION["userid"] = $idfromdb;
					$_SESSION["userfirstname"] = $firstnamefromdb;
					$_SESSION["userlastname"] = $lastnamefromdb;
					$stmt->close();
					$conn->close();
					header("Location: home.php");
					exit();
				} else {
					$notice = "Vale salasõna!";
				}
			} else {
				$notice = "Sellist kasutajat (" .$email .") kahjuks pole!";
			}
		} else {
			$notice = "Sisselogimisel tekkis tehniline viga: " .$stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function storeuserprofile($description, $bgcolor, $txtcolor) {
		$notice = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT vpuserprofiles_id FROM vpuserprofiles WHERE userid = ?");
		echo $conn->error;
		$stmt->bind_param("i", $_SESSION["userid"]);
		$stmt->bind_result($profileidfromdb);
		if($stmt->execute()) {
			if($stmt->fetch()) {
				$stmt->close();
				$stmt = $conn->prepare("UPDATE vpuserprofiles SET description = ?, bgcolor = ?, txtcolor = ? WHERE userid = ?");
				echo $conn->error;
				$stmt->bind_param("sssi", $description, $bgcolor, $txtcolor, $_SESSION["userid"]);
				if($stmt->execute()) {
					$notice = "Profiil uuendatud!";
				} else {
					$notice = $stmt->error;
				}
			} else {
				$stmt->close();
				$stmt = $conn->prepare("INSERT INTO vpuserprofiles (userid, description, bgcolor, txtcolor) VALUES (?, ?, ?, ?)");
				echo $conn->error;
				$stmt->bind_param("isss", $_SESSION["userid"], $description, $bgcolor, $txtcolor);
				if($stmt->execute()) {
					$notice = "Profiil salvestatud!";
				} else {
					$notice = $stmt->error;
				}
			}
		} else {
			$notice = $stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function readuserdescription() {
		//kui profiil on olemas, loeb kasutaja lühitutvustuse
		
		$notice = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT description FROM vpuserprofiles WHERE userid = ?");
		echo $conn->error;
		$stmt->bind_param("i", $_SESSION["userid"]);
		$stmt->bind_result($descriptionfromdb);
		if($stmt->execute()) {
			if($stmt->fetch()) {
				$_SESSION["userdescription"] = $descriptionfromdb;
			}
		} else {
			$notice = $stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
?>