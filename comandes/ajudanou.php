<?php include ("seguridad.php");
include("conexion.php");
    $id = $_POST['id'];
    $item = addslashes($_POST['item']);
    $text = addslashes($_POST['text']);
    if ($_POST['num']==0) {
        $sql = 'INSERT INTO ajuda (pagina, item, text) VALUES ("'.$id.'", "'.$item.'", "'.$text.'")';
    } else {
        $sql = 'UPDATE ajuda SET item = "'.$item.'", text = "'.$text.'" WHERE pagina="'.$id.'"';
    }
	$result = mysqli_query($link,$sql);

	// Afegeix registre d'activitat
    $tx= 'Ajuda: '.$item;
    $sqlact = 'INSERT INTO activitat (user, obs, data) VALUES ("'.$_SESSION['profe'].'", "'.$tx.'", NOW())';
	$resultact = mysqli_query($link,$sqlact);
    mysqli_close($link);
    header ("Location: ajuda.php?id=$id");
?>