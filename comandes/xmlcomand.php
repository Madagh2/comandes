<?php include ("seguridad.php");?>
<!DOCTYPE html>
<html lang="ca">
<head>
<?php include ("head.php");?>
</head>
<body>
  <?php
    include("conexion.php");
    $a=$_SESSION['anyacad'];
  	$titol="Crear taula comand".$a;
  	include ("capg.php");
	?>
<main>
  <div class="container">
    <div class="card">
  <?php 
  $sql="CREATE TABLE IF NOT EXISTS `comanda".$a."` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `uid` int(11) NOT NULL,
    `profe` varchar(255) NOT NULL,
    `departament` varchar(50) NOT NULL,
    `materia` varchar(110) NOT NULL,
    `curs` varchar(75) NOT NULL,
    `proveidor` varchar(110) NOT NULL,
    `data` datetime NOT NULL,
    `cdaut` varchar(1) NOT NULL DEFAULT 'N',
    `cdautdata` date NOT NULL,
    `edaut` varchar(1) NOT NULL DEFAULT 'N',
    `edautdata` date NOT NULL,
    `observacions` text NOT NULL,
    `val` int(11) NOT NULL DEFAULT '0',
    `valimpr` varchar(1) NOT NULL DEFAULT 'N',
    `adjunt` varchar(12) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1;";

  echo $sql,"<br><br>";
  if(mysqli_query($link,$sql)){
      print "S'ha creat la base de dades comanda".$a."<br><br>";
      // Afegeix registre d'activitat
      $sqlact = 'INSERT INTO activitat (user, obs, data) VALUES ("'.$_SESSION['profe'].'", "Actualitzada taula comanda'.$a.', NOW())';
      $resultact = mysqli_query($link,$sqlact);
  }else{
      print "S'ha producït un error creant la taula comanda".$a."<br><br>";
  }

  $sql="CREATE TABLE IF NOT EXISTS `comandadetall".$a."` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `idcom` int(11) NOT NULL,
    `program` varchar(150) NOT NULL,
    `material` varchar(150) NOT NULL,
    `quantitat` tinyint(4) NOT NULL DEFAULT '1',
    `preu` double NOT NULL,
    `preutot` double NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1;";

  echo $sql,"<br><br>";
  if(mysqli_query($link,$sql)){
      print "S'ha creat la base de dades comandadetall".$a."<br><br>";

      // Afegeix registre d'activitat
      $sqlact = 'INSERT INTO activitat (user, obs, data) VALUES ("'.$_SESSION['profe'].'", "Actualitzada taula comandadetall'.$a.', NOW())';
      $resultact = mysqli_query($link,$sqlact);
  }else{
      print "S'ha producït un error creant la taula comandadetall".$a."<br><br>";
  }
  $url=$_GET['url'].".php";
  echo '<a href="'.$url.'">Tornar</a>';
  ?>
    </div>
  </div>
</main>
<?php include("footer.php");?>
<script>
  Url='<?php echo $url;?>'
  Win='_self'
  Time=60000
  setTimeout("open(Url,Win)",Time);
</script>
</body>
</html>
