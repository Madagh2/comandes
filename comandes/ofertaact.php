<?php
include ("seguridad.php");
include("conexion.php");

$oid = $_POST['oid'];
$familia = addslashes($_POST['familia']);
$familiaa = addslashes($_POST['familiaa']);
if ($familiaa!="") {$familia=$familiaa;}
$nivell = $_POST['nivell'];
$codi = $_POST['codi'];
$nom = addslashes($_POST['nom']);

if ($oid==0) {
    $sql = "INSERT INTO oferta (familia, nivell, codi, nom) VALUES ('".$familia."', '".$nivell."', '".$codi."', '".$nom."')";
    $result = mysqli_query($link,$sql);
    //echo $sql;
} else {
    /*$sql = "UPDATE comanda".$a." SET departament='".$departament."', materia='".$materia."', curs='".$curs."', proveidor='".$proveidor."' WHERE id='".$cid."'";
    $result = mysqli_query($link,$sql);
    $text="Modificada comanda de ".$departament;*/
}

mysqli_close($link);
header ("Location: oferta.php");
?>