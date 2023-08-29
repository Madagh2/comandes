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
  $titol="Crear taula departaments ".$a;
  include ("capg.php");?>
<main>
  <div class="container">
    <?php
    $sqld="DROP TABLE IF EXISTS `deps".$a."`";
    echo $sqld,"<br>";
    if(mysqli_query($link,$sqld)){
    	print "S'ha esborrat la base de dades<br><br>";
    }else{
        print "S'ha producït un error esborrant la base de dades<br>v";
    	 }

    $sqlc="CREATE TABLE IF NOT EXISTS `deps".$a."` (`codi` VARCHAR(4) NOT NULL, `departament` VARCHAR(75), PRIMARY KEY (`codi`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    echo $sqlc,"<br>";
    if(mysqli_query($link,$sqlc)){
      print "S'ha creat la base de dades<br><br>";
    }else{
        print "S'ha producït un error creant la base de dades<br><br>";
       }


    $sql="INSERT INTO `deps".$a."` (`codi`, `departament`) VALUES ";
    echo $sql,"<br>";
    if (file_exists('exportacioDadesCentre'.$a.'.xml')) {
        $xml = simplexml_load_file('exportacioDadesCentre'.$a.'.xml');
    } else {
        exit('Error al abrir exportacioDadesCentre'.$a.'.xml.');
    }
    $n=1;
    foreach ($xml->DEPARTAMENTS[0]->DEPARTAMENT as $dep) {
        $fila='("'.$dep['codi'].'", "'.$dep['descripcio'].'"), ';
        //echo $n," ",$name," ";
        echo $fila,"<br>";
        $n+=1;
        $sql.=$fila;
        }

    $sqll=substr($sql, 0, -2).";";

    if(mysqli_query($link,$sqll)){
    	print "S'han introduït les dades a la base de dades<br>";

      // Afegeix registre d'activitat
      $sqlact = 'INSERT INTO activitat (user, obs, data) VALUES ("'.$_SESSION['profe'].'", "Actualitzada taula deps'.$a.', NOW())';
      $resultact = mysqli_query($link,$sqlact);
    }else{
        print "S'ha producït un error introduint les dades a la base de dades";
    	 }

    ?>
    <p><a href="xmlcreatablas.php">Tornar</a></p>
  </div>
</main>
<?php include("footer.php");?>
<script>
Url='xmlcreatablas.php'
Win='_self'
Time=60000
//setTimeout("open(Url,Win)",Time);
</script>
</body>
</html>