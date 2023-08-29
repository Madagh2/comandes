<?php
include ("seguridad.php");
include("conexion.php");

if($_FILES['archivo']['name'] == "" OR $_FILES['archivo']['tmp_name'] == ""){
  header ("Location: xmlcreatablas.php?e=4"); 
  exit();
}

$a=$_SESSION['anyacad'];
if($_FILES['archivo']['size']>33554432){
    header ("Location: xmlcreatablas.php?e=1");
    exit();
}

if($_FILES['archivo']['type']!="text/xml"){
  header ("Location: xmlcreatablas.php?e=2"); 
  exit();
}

$adjunt="exportacioDadesCentre".$a.".xml";
if(file_exists($adjunt)) {
    unlink($adjunt);
}

if(move_uploaded_file($_FILES['archivo']['tmp_name'],$adjunt)){
}else{
  header ("Location: xmlcreatablas.php?e=3");
}

// Afegeix registre d'activitat
$sqlact = "INSERT INTO activitat (user, obs, data) VALUES ('".$_SESSION['profe']."', 'Actualitzat fitxer XML', NOW())";
$resultact = mysqli_query($link,$sqlact);

mysqli_close($link);
header ("Location: xmlcreatablas.php?e=0");
?>