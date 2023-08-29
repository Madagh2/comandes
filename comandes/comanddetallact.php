<?php
include ("seguridad.php");
include("conexion.php");
$cid=$_POST['cid'];
$a=$_SESSION['anyacad'];

$sql = "select * from comandadetall".$a." WHERE idcom='".$cid."' ORDER BY id";
$res = mysqli_query($link,$sql);
while($row = mysqli_fetch_array ($res))
{
    $id = $row['id'];
    $program=addslashes($_POST['program'.$id]);
    $material=addslashes($_POST['material'.$id]);
    $quantitat=$_POST['quantitat'.$id];
    $preu=  str_replace(",",".", $_POST['preu'.$id]);
    $esborrar =$_POST['esborrar'.$id];
    if ($esborrar=="si") {
      mysqli_query($link,"DELETE FROM comandadetall".$a." WHERE id='".$id."'");
    } else {
      mysqli_query($link,'UPDATE comandadetall'.$a.' SET program = "'.$program.'", material="'.$material.'", quantitat="'.$quantitat.'", preu="'.$preu.'" WHERE id="'.$id.'"');
    }
}

$program=addslashes($_POST['program']);
$material=addslashes($_POST['material']);
$quantitat=$_POST['quantitat'];
$preu=str_replace(",",".", $_POST['preu']);
if ($material!="" && $quantitat!="") {
  $sqln = 'INSERT INTO comandadetall'.$a.' (program, material, quantitat, preu, idcom) VALUES ("'.$program.'", "'.$material.'", "'.$quantitat.'", "'.$preu.'", "'.$cid.'")';
  $resultn = mysqli_query($link,$sqln);
}

// Afegeix registre d'activitat
$text="Actualitzada comanda n. ".$cid." de ".$_SESSION['depart'];
$sqlact = 'INSERT INTO activitat (user, obs, data) VALUES ("'.$_SESSION['profe'].'", "'.$text.'", NOW())';
$resultact = mysqli_query($link,$sqlact);
mysqli_close($link);
$torna="Location: comanddetall.php?cid=".$cid."#detall";
header ("$torna");
?>