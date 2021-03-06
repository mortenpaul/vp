<?php
	$database = "if20_morten_mu_3";

	function storePhotoData($filename, $alttext, $privacy){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("INSERT INTO vpphotos (userid, filename, alttext, privacy) VALUES (?, ?, ?, ?)");
		echo $conn->error;
		$stmt->bind_param("issi", $_SESSION["userid"], $filename, $alttext, $privacy);
		if($stmt->execute()){
			$notice = 1;
		} else {
			//echo $stmt->error;
			$notice = 0;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function readPublicPhotoThumbs($privacy) {
		$photohtml = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy >= ? AND deleted IS NULL ORDER BY vpphotos_id DESC");
		echo $conn->error;
		$stmt->bind_param("i", $privacy);
		$stmt->bind_result($filenamefromdb, $alttextfromdb);
		$stmt->execute();
		$temphtml = null;
		while($stmt->fetch()) {
			//<img src="failinimi.laiend" alt="alternatiivtekst">
			$temphtml .= '<img src="' .$GLOBALS["photouploaddir_thumb"] .$filenamefromdb .'" alt="' .$alttextfromdb .'">' ."\n";
		}
		if(!empty($temphtml)) {
			$photohtml = "<div> \n" .$temphtml ."\n </div> \n";
		} else {
			$photohtml = "<p>Kahjuks galeriipilte ei leitud!</p> \n";
		}
		$stmt->close();
		$conn->close();
		return $photohtml;
	}
	
	function readPublicPhotoThumbsPage($privacy, $limit, $page) {
		$photohtml = null;
		$skip = ($page - 1) * $limit;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		//$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy >= ? AND deleted IS NULL ORDER BY vpphotos_id DESC LIMIT ?");
		$stmt = $conn->prepare("SELECT vpphotos_id, filename, alttext FROM vpphotos WHERE privacy >= ? AND deleted IS NULL ORDER BY vpphotos_id DESC LIMIT ?, ?");
		echo $conn->error;
		$stmt->bind_param("iii", $privacy, $skip, $limit);
		$stmt->bind_result($idfromdb, $filenamefromdb, $alttextfromdb);
		$stmt->execute();
		$temphtml = null;
		while($stmt->fetch()) {
			//<div class="thumbgallery">
			//<img src="failinimi.laiend" alt="alternatiivtekst" class="thumbs">
			$temphtml .= '<div class="thumbgallery">' ."\n";
			//$temphtml .= '<img src="' .$GLOBALS["photouploaddir_thumb"] .$filenamefromdb .'" alt="' .$alttextfromdb .'" class="thumbs" data-fn="' .$filenamefromdb .'" data-id="' .$idfromdb .'">' ."\n";
			$temphtml .= '<img src="showphoto.php?photo=' .$idfromdb .'&thumb=1' .'" alt="' .$alttextfromdb .'" class="thumbs" data-id="' .$idfromdb .'">' ."\n";
			$temphtml .= "</div> \n";
		}
		if(!empty($temphtml)) {
			$photohtml = '<div id="galleryarea" class="galleryarea">' ."\n" .$temphtml ."\n </div> \n";
		} else {
			$photohtml = "<p>Kahjuks galeriipilte ei leitud!</p> \n";
		}
		$stmt->close();
		$conn->close();
		return $photohtml;
	}
	
	function countPublicPhotos($privacy) {
		$photocount = 0;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT COUNT(vpphotos_id) FROM vpphotos WHERE privacy >= ? AND deleted IS NULL");
		echo $conn->error;
		$stmt->bind_param("i", $privacy);
		$stmt->bind_result($result);
		$stmt->execute();
		if($stmt->fetch()) {
			$photocount = $result;
		}
		$stmt->close();
		$conn->close();
		return $photocount;
	}
?>