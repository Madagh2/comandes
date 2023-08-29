<?php
include ("seguridad.php");
include("conexion.php");

$sqlr="SELECT * FROM permisos";
$queryr = mysqli_query($link,$sqlr);
while ($rowr = mysqli_fetch_assoc($queryr))
{
    $id=$rowr['id'];
    if ($_POST['esb'.$id]==1) {
        mysqli_query($link,"DELETE FROM permisos WHERE id='".$id."'");
        // Afegeix registre d'activitat
        $sqlact = 'INSERT INTO activitat (user, obs, data) VALUES ("'.$_SESSION['profe'].'", "Esborrat permís '.$id.' '.$rowr['descr'].'", NOW())';
        $resultact = mysqli_query($link,$sqlact);
    } else {
        $descr=$_POST['descr'.$id];
        if ($rowr['descr'] != $descr) {
            mysqli_query($link,'UPDATE permisos SET descr="'.$descr.'" WHERE id="'.$id.'"');
            // Afegeix registre d'activitat
            $sqlact = 'INSERT INTO activitat (user, obs, data) VALUES ("'.$_SESSION['profe'].'", "Actualitzat permís '.$id.' '.$descr.'", NOW())';
            $resultact = mysqli_query($link,$sqlact);
        }
    }
}

$codi=$_POST['codi'];
if ($codi!="") {
    $descr=addslashes($_POST['descr']);
    mysqli_query($link,'INSERT INTO permisos (codi, descr) VALUES ("'.$codi.'", "'.$descr.'")');
    $pid=mysqli_insert_id($link);

    // Afegeix registre d'activitat
    $sqlact = 'INSERT INTO activitat (user, obs, data) VALUES ("'.$_SESSION['profe'].'", "Creat permís '.$pid.' '.$descr.'", NOW())';
    $resultact = mysqli_query($link,$sqlact);
}

mysqli_close($link);
header ("Location: permisosges.php");
?>