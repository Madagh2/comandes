<?php
include ("seguridad.php");
include("conexion.php");
$cid=$_GET['cid'];
$a=$_SESSION['anyacad'];
mysqli_query($link,"DELETE FROM comanda".$a." WHERE id='".$cid."'");
mysqli_query($link,"DELETE FROM comandadetall".$a." WHERE idcom='".$cid."'");
$adjunt="adjunts/comandes/".$cid.".pdf";
if(file_exists($adjunt)) {
  unlink($adjunt);
}

// Afegeix registre d'activitat
$text="Esborrada comanda n. ".$cid;
$sqlact = "INSERT INTO activitat (user, obs, data) VALUES ('".$_SESSION['profe']."', '".$text."', NOW())";
$resultact = mysqli_query($link,$sqlact);

mysqli_close($link);
header ("Location: comand.php");
?>