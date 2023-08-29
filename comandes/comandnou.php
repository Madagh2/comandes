<?php
include ("seguridad.php");
include("conexion.php");

$a=$_SESSION['anyacad'];
$cid = $_POST['cid'];
$uid = $_POST['uid'];
$profe = addslashes($_POST['profe']);
$departament = addslashes($_POST['departament']);
$curs = addslashes($_POST['curs']);
$materia = addslashes($_POST['materia']);
$materiaa = addslashes($_POST['materiaa']);
if ($materiaa!="") {$materia=$materiaa;}
$proveidor = addslashes($_POST['proveidor']);
$proveidora = addslashes($_POST['proveidora']);
if ($proveidora!="") {$proveidor=$proveidora;}
$adj="";

if ($cid==0) {
    $sql = "INSERT INTO comanda".$a." (uid, profe, departament, materia, curs, proveidor, data) VALUES ('".$uid."', '".$profe."', '".$departament."', '".$materia."', '".$curs."', '".$proveidor."', NOW())";
    $result = mysqli_query($link,$sql);
    $cid=mysqli_insert_id($link);
    $text="Nova comanda de ".$departament;
} else {
    $sql = "UPDATE comanda".$a." SET departament='".$departament."', materia='".$materia."', curs='".$curs."', proveidor='".$proveidor."' WHERE id='".$cid."'";
    $result = mysqli_query($link,$sql);
    $text="Modificada comanda de ".$departament;
}
$torna="comanddetall.php?cid=".$cid;

// Adjuntar full de comanda
$carpeta="adjunts/comandes";
if(!file_exists($carpeta)) {
    if(!mkdir($carpeta, 0777, true)) {
       die('Error creant carpetes...');
    }
}
$mida = $_FILES['archivo']['size'];
if ($_FILES['archivo']['name'] != "" && $mida != 0) {
  if($mida>26214400) {
      print $nom."<br>";
      print "La mida ".$mida." excedeix el límit de 25Mb";
      ?><br /><a href="<?php echo $torna;?>"><input type="button" name="" value="Tornar" /></a><?php 
      exit();
  }
  $tipus = $_FILES['archivo']['type'];
  if($tipus!="application/pdf") {
      print "No és un document PDF";
      ?><br /><a href="<?php echo $torna;?>"><input type="button" name="" value="Tornar" /></a><?php 
      exit();
  }

  $aci=$cid.".pdf";
  $adjunt=$carpeta."/".$aci;
  if ($_FILES['archivo']['tmp_name'] != "" ) {
      $err="";
      if(file_exists($adjunt)) {
          unlink($adjunt);
      }
      if (copy($_FILES['archivo']['tmp_name'], $adjunt)) {
          $sql = "UPDATE comanda".$a." SET adjunt='".$aci."' WHERE id='".$cid."'";
          $result = mysqli_query($link,$sql);
      }
      $adj="&adj=1";
  } else{?>
      <h2>No s'ha pogut adjuntar el full de comanda</h2>
      <br /><a href="comand.php"><input type="button" name="" value="Tornar al formulari" /></a><?php
      $err="Fitxer no vàlid";
      exit();
  }
}

// Afegeix registre d'activitat
$sqlact = "INSERT INTO activitat (user, obs, data) VALUES ('".$_SESSION['profe']."', '".$text."', NOW())";
$resultact = mysqli_query($link,$sqlact);

if ($departament=="Centre") {
    $sqlcd = "UPDATE comanda".$a." SET cdaut='S',cdautdata=NOW() WHERE id='".$cid."'";
    mysqli_query($link,$sqlcd);
}

mysqli_close($link);
$torna.=$adj;
header ("Location: $torna");
?>