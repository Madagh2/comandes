<?php
include ("seguridad.php");
include("conexion.php");
$c=$_GET['c'];
$a=$_SESSION['anyacad'];
mysqli_query($link,"DELETE FROM backup WHERE copia='".$c."'");
$filename = 'backup/'.$c.'.sql.gz';
if (file_exists($filename)) {
    unlink($filename);
} else {
    echo 'The file does not exist.';
}

// Afegeix registre d'activitat
$text="Esborrada còpia de seguretat ".$c;
$sqlact = "INSERT INTO activitat (user, obs, data) VALUES ('".$_SESSION['profe']."', '".$text."', NOW())";
$resultact = mysqli_query($link,$sqlact);

mysqli_close($link);
header ("Location: copies.php");
?>