<?php
include ("seguridad.php");
include("conexion.php");
//conecto con la base de datos
//Sentencia SQL para buscar unusuario con esos datos
$uid = $_POST['uid'];
$nom = mb_convert_case($_POST['nom'], MB_CASE_TITLE, "UTF-8");
$user = $_POST['user'];
$email = $_POST['email'];
$pass = md5($_POST['pass']);
$departament = $_POST['departament'];
$nivell = $_POST['nivell'];
$capdep = ($_POST['capdep'] == 1 ? 1 : 0);
$autoritzat = $_POST['autoritzat'];
$dma=explode('/',$_POST['altacentre']);
$altacentre=$dma[2].'-'.$dma[1].'-'.$dma[0];

$sql = "UPDATE usuaris SET email='".$email."'";
if ($_POST['pass']!='') {$sql.=", pass='$pass', passcheck=NOW()";}
if (!isset($_POST['nivtxt'])) {$sql.=', nom="'.$nom.'", user="'.$user.'", departament="'.$departament.'", nivell="'.$nivell.'", capdep="'.$capdep.'", autoritzat="'.$autoritzat.'", altacentre="'.$altacentre.'"';}
$sql.=" WHERE uid='$uid'";
$result = mysqli_query($link,$sql);

$com="Actualitzat usuari ".$user.", ".$nom;
$sqlact = "INSERT INTO activitat (user, obs, data) VALUES ('".$_SESSION['profe']."', '".$com."', NOW())";
$resultact = mysqli_query($link,$sqlact);

$tornar = (isset($_POST['nivtxt'])) ? "menu.php" : ($autoritzat=="0" ? "usuaris.php" : "usuedit.php?uid=".$uid);
header("Location: $tornar");
?>