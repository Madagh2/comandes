<?php
include ("seguridad.php");
include("conexion.php");
$a=$_SESSION['anyacad'];
$id = $_GET['id'];
$au = $_GET['au'];
$sql = "select * from comanda".$a." WHERE id='".$id."'";
$res = mysqli_query($link,$sql);
while($row = mysqli_fetch_array ($res))
{
    $profe = stripslashes($row['profe']);
    $departament = $row['departament'];
}
switch ($au) {
    case "CD":
        $sql = "UPDATE comanda".$a." SET cdaut='N',cdautdata='0' WHERE id='".$id."'";
        mysqli_query($link,$sql);
        $text = "Comanda n. '.$id.' desautoritzada per Cap Departament";
        break;
    default :
        $sql = "UPDATE comanda".$a." SET cdaut='S',cdautdata=NOW() WHERE id='".$id."'";
        mysqli_query($link,$sql);
        $text = "Comanda n. '.$id.' autoritzada per Cap Departament";
        break;
}

// Afegeix registre d'activitat
$sqlact = 'INSERT INTO activitat (user, obs, data) VALUES ("'.$_SESSION['profe'].'", "'.$text.'", NOW())';
$resultact = mysqli_query($link,$sqlact);

mysqli_close($link);
header ("Location: comand.php");
?>
