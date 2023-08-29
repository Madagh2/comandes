<?php
include ("seguridad.php");
include("conexion.php");
$a=$_SESSION['anyacad'];
$data=date("y-m-d H.i.s");
$tablas = "ajuda,backup,dades,oferta,permisos,usuaris,";

$sql = "SELECT table_name FROM information_schema.tables WHERE table_schema = '".$db."' AND table_name LIKE '%".$a."'";
$result = $link->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $tablas .= $row["table_name"] . ",";
  }
}

$tablas = substr($tablas, 0, -1);

include("backup.php");

$fitxer = $backupDatabase->backupFile;
// Afegeix backup a la taula
$sqlact = "INSERT INTO backup (copia) VALUES ('".substr($fitxer,0,-4)."')";
$resultact = mysqli_query($link,$sqlact);

// Afegeix registre d'activitat
$sqlact = "INSERT INTO activitat (user, obs, data) VALUES ('".$_SESSION['profe']."', 'Còpia de seguretat ".$fitxer."', NOW())";
$resultact = mysqli_query($link,$sqlact);

mysqli_close($link);
?>
<p><a href="xmlcreatablas.php">Tornant</a> en <span id="countdown">10</span> segons</p>
<script>
    var count = 10;
    var interval = setInterval(function() {
    count--;
    document.getElementById("countdown").innerHTML = count;
    if (count == 0) {
        clearInterval(interval);
        window.location.href = "xmlcreatablas.php";
    }
    }, 1000);
</script>
