<?php
include ("seguridad.php");
include("conexion.php");

$a=$_SESSION['anyacad'];
$mida = $_FILES['archivo']['size'];
if($mida == 0){
  print "No has adjuntat cap arxiu";
  ?><br /><a href="<?php echo $url;?>"><input type="button" name="" value="Tornar" /></a><?php 
  exit();
}
if($mida>26214400){
    print "La mida ".$mida." excedeix el límit de 25Mb";
    ?><br /><a href="<?php echo $url;?>"><input type="button" name="" value="Tornar" /></a><?php 
    exit();
}
$tipus = $_FILES['archivo']['type'];
if($tipus!="image/png"){
    print "No és un arxiu d'imatge PNG";
    ?><br /><a href="<?php echo $url;?>"><input type="button" name="" value="Tornar" /></a><?php 
    exit();
}
$img = $_POST['img'];
$url = $_POST['url'].".php";
$arxiu = $_FILES['archivo']['tmp_name'];
$nom = $_FILES['archivo']['name'];
list($x, $y) = getimagesize($arxiu);
$adjunt="img/".$img.".png";
if(file_exists($adjunt)) {
    unlink($adjunt);
}
echo $arxiu,"<br>";
echo $nom,"<br>";
echo $mida,"<br>";
echo $tipus,"<br>";
echo $width,"<br>";
echo "adjunt - ",$adjunt,"<br />";
if(isset($_POST['width'])) {
    $width = $_POST['width'];
    $rel=$x/$y;
    $height=round($width/$rel);
    $image = imagecreatefrompng($arxiu);
    $lienzo = imagecreatetruecolor($width, $height);
    imagealphablending($lienzo, false);
    imagesavealpha($lienzo, true);
    $transparent = imagecolorallocatealpha($lienzo, 255, 255, 255, 127);
    imagefilledrectangle($lienzo, 0, 0, $width, $height, $transparent);
    imagecopyresampled($lienzo, $image, 0, 0, 0, 0, $width, $height, $x, $y);
    imagepng($lienzo, $adjunt);
} else {
    $lienzo = imagecreatefrompng($arxiu);
    imagealphablending($lienzo, false);
    imagesavealpha($lienzo, true);
    imagepng($lienzo, $adjunt);
    imagedestroy($lienzo);
}

//Crear icona de la web
if ($img=="logosol") {
    $adjunt="img/icona.ico";
    if(file_exists($adjunt)) {
      unlink($adjunt);
    }
    $icon = imagecreatefrompng($arxiu);
    $icona = imagecreatetruecolor( 64, 64);
    imagealphablending($icona, false);
    imagesavealpha($icona, true);
    $transparent = imagecolorallocatealpha($icona, 255, 255, 255, 127);
    imagefilledrectangle($icona, 0, 0, 64, 64, $transparent);
    imagecopyresampled($icona, $icon, 0, 0, 0, 0, 64, 64, $x, $y);
    imagepng($icona, $adjunt);
    imagedestroy($icona);
}

// Afegeix registre d'activitat
$sqlact = 'INSERT INTO activitat (user, obs, data) VALUES ("'.$_SESSION['profe'].'", "Actualitzada imatge '.$dep.'", NOW())';
$resultact = mysqli_query($link,$sqlact);

mysqli_close($link);
header ("Location: $url");
?>