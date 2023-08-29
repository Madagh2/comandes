<?php
include ("seguridad.php");
include("conexion.php");

$a=$_SESSION['anyacad'];
$cid = $_GET['cid'];
$adjunt="adjunts/comandes/".$cid.".pdf";
$text="Esborrat full de comanda ".$cid;
if(file_exists($adjunt)) {
  unlink($adjunt);
}
$sql = "UPDATE comanda".$a." SET adjunt='' WHERE id='".$cid."'";
$result = mysqli_query($link,$sql);

// Afegeix registre d'activitat
$sqlact = "INSERT INTO activitat (user, obs, data) VALUES ('".$_SESSION['profe']."', '".$text."', NOW())";
$resultact = mysqli_query($link,$sqlact);

mysqli_close($link);
$torna="comanddetall.php?cid=".$cid;
header ("Location: $torna");
?>