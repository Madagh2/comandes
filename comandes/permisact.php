<?php include ("seguridad.php");
include("conexion.php");
$uid=$_POST['uid'];
$permis=0;

$sqlr="SELECT id FROM permisos";
$queryr = mysqli_query($link,$sqlr);
while ($rowr = mysqli_fetch_assoc($queryr))
{
    $id=$rowr['id'];
    $pos=pow(2,$rowr['id']-1);
    if ($_POST['alt'.$id]==1) {$permis+=$pos;}
}

$sql = "UPDATE usuaris SET permis='".$permis."' WHERE uid='".$uid."'";
$result = mysqli_query($link,$sql);

mysqli_close($link);
$tornar='usuedit.php?uid='.$uid;
header ("Location: $tornar");
?>