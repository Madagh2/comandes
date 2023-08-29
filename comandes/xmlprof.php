<?php include ("seguridad.php");?>
<!DOCTYPE html>
<html lang="ca">
<head>
<?php include ("head.php");?>
</head>
<body>
<?PHP
  include("conexion.php");
  $a=$_SESSION['anyacad'];
  $titol="Crear taula professorat ".$a;
  include ("capg.php");
?>
<main>
  <div class="container">
    <?php
    if (tabla_existe("deps".$a,$link,$db)=="Taula no existent") {
        echo "És necessari crear abans la taula deps".$a;
    } else {
        $sqld="DROP TABLE IF EXISTS `profes".$a."`; ";
        echo $sqld,"<br>";
        if(mysqli_query($link,$sqld)){
          print "S'ha esborrat la taula<br><br>";
        }else{
            print "S'ha producït un error esborrant la taula<br>v";
          }

        $sqlc="CREATE TABLE IF NOT EXISTS `profes".$a."` (`uid` mediumint(8) NOT NULL, `codi` VARCHAR(50) NOT NULL, `ap1` VARCHAR(50), `ap2` VARCHAR(50), `nom` VARCHAR(50), `usergestib` VARCHAR(12), `dep` VARCHAR(75), `nivell` VARCHAR(1), `capdep` VARCHAR(1), PRIMARY KEY (`codi`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        echo $sqlc,"<br>";
        if(mysqli_query($link,$sqlc)){
          print "S'ha creat la taula<br><br>";
        }else{
            print "S'ha producït un error creant la taula<br><br>";
          }
        $sql="INSERT INTO `profes".$a."` (`uid`, `codi`, `ap1`, `ap2`, `nom`, `usergestib`, `dep`, `nivell`, `capdep`) VALUES ";
        echo $sql,"<br>";

        if (file_exists('exportacioDadesCentre'.$a.'.xml')) {
            $xml = simplexml_load_file('exportacioDadesCentre'.$a.'.xml');
        } else {
            exit('Error al abrir exportacioDadesCentre'.$a.'.xml.');
        }
        $n=1;
        foreach ($xml->PROFESSORS[0]->PROFESSOR as $profe) {
            $uid=0;
            $nivell=5;
            $dep="No consta";
            $sqlp="SELECT * FROM usuaris WHERE departament<>'' AND autoritzat='1' AND UCASE(nom)='".$profe['ap1']." ".$profe['ap2'].", ".$profe['nom']."'";
            $queryp = mysqli_query($link,$sqlp);
            while ($rowp = mysqli_fetch_array($queryp)) {
              $uid=$rowp['uid'];
              $name=$rowp['nom'];
              $dep=$rowp['departament'];
              $nivell=$rowp['nivell'];
              $capdep=$rowp['capdep'];
            }

            $sqld="SELECT * FROM `deps".$a."` WHERE codi='".$profe['departament']."'";
            $queryd = mysqli_query($link,$sqld);
            $rowd = mysqli_fetch_array($queryd);
            $depx=$rowd['departament'];

            $fila='("'.$uid.'", "'.$profe['codi'].'", "'.$profe['ap1'].'", "'.$profe['ap2'].'", "'.$profe['nom'].'", "'.$profe['username'].'", "'.$depx.'", "'.$nivell.'", "'.$capdep.'"), ';
            //echo $n," ",$name," ";
            $color="white";
            if ($dep!=$depx) {$color="yellow";}
            if ($dep=="No consta") {$color="red";}
            echo "<a href='usuedit.php?uid=".$uid."&codi=".$profe['codi']."' class='",$color,"'>\n<!-- ",$sqlp," -->",$fila,"</a><br>";
            $n+=1;
            $sql.=$fila;
            }

        $sqll=substr($sql, 0, -2).";";
        if(mysqli_query($link,$sqll)){
            print "S'han introduït les dades a la base de dades<br>";

            // Afegeix registre d'activitat
            $sqlact = 'INSERT INTO activitat (user, obs, data) VALUES ("'.$_SESSION['profe'].'", "Actualitzada taula profes'.$a.', NOW())';
            $resultact = mysqli_query($link,$sqlact);

        }else{
            print "S'ha producït un error introduint les dades a la base de dades";
        }
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