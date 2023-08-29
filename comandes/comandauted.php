<?php
include ("seguridad.php");
include("conexion.php");
$a=$_SESSION['anyacad'];
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $au = $_GET['au'];
    $sql = "select * from comanda".$a." WHERE id='".$id."'";
    $res = mysqli_query($link,$sql);
    while($row = mysqli_fetch_array ($res))
    {
        $profe = stripslashes($row['profe']);
        $departament = $row['departament'];
        $uid = $row['uid'];
    }

    switch ($au) {
        case "Si":
            $sql = "UPDATE comanda".$a." SET edaut='N', edautdata='0', val='0' WHERE id='".$id."'";
            mysqli_query($link,$sql);
            $text = "Comanda n. '.$id.' desautoritzada per Equip Directiu";
            break;
        default :
            $sqlm="SELECT max(val) AS max FROM comanda".$a;
            $resm = mysqli_query($link,$sqlm);
            $rowm = mysqli_fetch_array ($resm);
            $nval=$rowm['max']+1;
            $sql = "UPDATE comanda".$a." SET edaut='S',edautdata=NOW(), val='".$nval."' WHERE id='".$id."'";
            mysqli_query($link,$sql);
            $text = "Comanda n. '.$id.' autoritzada per Equip Directiu";
            break;
    }
} else {
    $id = $_POST['id'];
    $observacions = $_POST['observacions'];
    $sql = 'UPDATE comanda'.$a.' SET observacions="'.$observacions.'" WHERE id="'.$id.'"';
    mysqli_query($link,$sql);
    $text = "Observació en comanda n. '.$id.' per Equip Directiu";
}

// Afegeix registre d'activitat
$sqlact = 'INSERT INTO activitat (user, obs, data) VALUES ("'.$_SESSION['profe'].'", "'.$text.'", NOW())';
$resultact = mysqli_query($link,$sqlact);

mysqli_close($link);
header ("Location: comand.php");
?>
