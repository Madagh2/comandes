<?php
//conecto con la base de datos
include("conexion.php");

//Sentencia SQL para buscar un usuario con esos datos
$nom = mb_convert_case($_POST['nom'], MB_CASE_TITLE, "UTF-8");
$user = $_POST['user'];
$email = $_POST['email'];
$pass = md5($_POST['pass']);
$departament = $_POST['departament'];
$subs = $_POST['subs'];
$nivell = $_POST['nivell'];
$capdep = ($_POST['capdep'] == 1 ? 1 : 0);
$autoritzat = $_POST['autoritzat'];
$dma=explode('/',$_POST['altacentre']);
$altacentre=$dma[2].'-'.$dma[1].'-'.$dma[0];
//Ejecuto la sentencia
$sql = "INSERT INTO usuaris (nom, user, email, pass, departament, subs, nivell, capdep, autoritzat, altacentre) VALUES ('".$nom."', '".$user."', '".$email."', '".$pass."', '".$departament."', '".$subs."', '".$nivell."', '".$capdep."', '".$autoritzat."', '".$altacentre."')";
$result = mysqli_query($link,$sql);
$uid=mysqli_insert_id($link);

// Afegeix registre d'activitat
$com="Nou usuari ".$user.", ".$nom;
$sqlact = "INSERT INTO activitat (user, obs, data) VALUES ('".$profe."', '".$com."', NOW())";
$resultact = mysqli_query($link,$sqlact);

header("Location: usuedit.php?uid=$uid");
mysqli_close($link);
?>