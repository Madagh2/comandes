<?php
include ("seguridad.php");
include("conexion.php");
$carpeta="adjunts/".$_SESSION['uid']; //."/img/";
if(!file_exists('dades')) {
    if(!mkdir('dades', 0777, true)) {
       die('Fallo al crear carpetas...');
    }
}

$sql="SELECT * FROM dades ORDER BY id";
$res = mysqli_query($link,$sql);
while ($row = mysqli_fetch_assoc($res)) {
	$id='valor'.$row['id'];
	$camp=$row['camp'];
	$valor=$_POST[$id];
	$sqlu = 'UPDATE dades SET valor="'.$valor.'" WHERE id="'.$row['id'].'"';
	$resu = mysqli_query($link,$sqlu);
	$file="dades/".$camp.".php";
	unlink($file);
	$fh = fopen($file, 'w');
	switch($camp) {
		case 'color':
			$content = '<?php $colorweb = "'.$valor.'";?>';
			break;
		default:
			$content = '<?php echo "'.$valor.'";?>';
	}
	fwrite($fh, $content);
	fclose($fh);
}

// Registre d'activitat
$sqlact = "INSERT INTO activitat (user, obs, data) VALUES ('".$_SESSION['profe']."', 'Actualitzades les dades del centre', NOW())";
$resultact = mysqli_query($link,$sqlact);

$tornar="dades.php";
header("Location: $tornar");
?>