  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1>Morten-Paul programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  
  <a href="home.php">Avaleht</a>
  <hr>


<?php
  //loeme andmebaasi login ifo muutujad
  require("../../../config.php");
  require("fnc_film.php");


  require("header.php");
?>
  <?php echo readfilms(); ?>

</body>
</html>

