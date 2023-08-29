<?php
error_reporting(E_ERROR | E_PARSE);

function senseaccents($cadena){
    $tofind = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ";
    $replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn";
    return(strtr($cadena,$tofind,$replac));
}

include("conexion.php");
$usuari=$_POST['usuari'];
$contrasena=$_POST['contrasena'];
//echo MD5($contrasena);
$ok='0';
    
// Cerca a la taula usuaris i compara la clau  
$sql = "SELECT * FROM usuaris";
$query = mysqli_query($link,$sql);
while ($row = mysqli_fetch_array($query)) {
    $clau=$row['pass'];
    $uname=$row['user'];
    $uid=$row['uid'];
    $professor=$row['nom'];
    $email=$row['email'];
    $depart=$row['departament'];
    $nivell=$row['nivell'];
    $capdep=$row['capdep'];
    $autoritzat=$row['autoritzat'];
    $passcheck=$row['passcheck'];
    if (MD5($contrasena) == $clau AND $uname==$usuari AND $nivell!="" AND $autoritzat!="0") {
        $ok='1';
        break;
    }
}

// Si s'accepta l'inici de sessió...
if ($ok!=0) {
  // Es defineix la sessió i es creen les variables
  session_start();
  $_SESSION['autentificado']= "SI";
  $_SESSION['uname']= $uname;
  $_SESSION['uid']= $uid;
  $_SESSION['profe']= $professor;
  $_SESSION['email']= $email;
  $_SESSION['depart']= $depart;
  $_SESSION['nivell']= $nivell;
  $_SESSION['capdep']= $capdep;

  // Calcula el curs acadèmic i defineix les variables
  $cca=date("y");
  if (date("m")<8) {$cca-=1;}
  $cca.=$cca+1;
  $_SESSION['anyacad']= $cca;
  $_SESSION['anyact']= $cca;

  // Afegeix registre d'activitat i tanca la connexió 
  $sqlact = "INSERT INTO activitat (user, obs, data) VALUES ('$professor', 'Inici de sessió', NOW())";
  $resultact = mysqli_query($link,$sqlact);
  

  // Estableix l'URL de redirecció a menu.php
  $vincle="menu.php";

  // Si nivell és d'administrador comprova el darrer backup i redirecciona si han passat més de 3 dies
  if ($nivell=="0") {
      $vincle="menu.php";
      $sql = "SELECT * FROM backup ORDER BY id DESC LIMIT 1";
      $res = mysqli_query($link, $sql);
      mysqli_close($link);

      // Imprimir el registro más reciente
      if (mysqli_num_rows($res) > 0) {
          while($fila = mysqli_fetch_assoc($res)) {
              $darrer = substr($fila["copia"], 0, 10);
              $dma=explode('-',$darrer);
              $timestamp1 = mktime(0,0,0,$dma[1],$dma[2],'20'.$dma[0]); 
              $timestamp2 = mktime(0,0,0,date('m'),date('d'),date('Y'));
              $difback = round(($timestamp2-$timestamp1)/(60*60*24));
              $vincle .= ($difback > 7 ? "?d=".$difback : "");
          }
      } else {
        $vincle .= "?d=n";
      }
  }

  // Si la clau és la inicial es redirecciona a l'editor del perfil per canviar-la
  if ($contrasena == "comandes" OR $contrasenya == "admin")  {$vincle="usuedit.php?cc=1&uid=".$uid;}

  //echo $contrasena,"<br>",$vincle;
  header ("Location: $vincle");
} else {
  header("Location: index.html");
}
?>