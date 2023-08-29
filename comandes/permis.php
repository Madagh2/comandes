<?php
function permis($codi) {
    global $link;
    $p=0;
    $sqlr="SELECT max(id) as t FROM permisos";
    $queryr = mysqli_query($link,$sqlr);
    $rowr = mysqli_fetch_assoc($queryr);
    $nr=$rowr['t'];
    $sqlp="SELECT BIN(permis) AS alt FROM usuaris WHERE uid='".$_SESSION['uid']."'";
    $queryp = mysqli_query($link,$sqlp);
    $rowp = mysqli_fetch_assoc($queryp);
    $permis=substr(str_repeat("0", $nr).$rowp['alt'],-$nr);
    $sqlp="SELECT * FROM permisos WHERE codi='".$codi."'";
    $queryp = mysqli_query($link,$sqlp);
    while ($rowp = mysqli_fetch_assoc($queryp)) {
      $p=substr($permis,-$rowp['id'],1);
    }
    return($p);
}
function permisuid($codi,$uid) {
    global $link;
    $p=0;
    $sqlr="SELECT max(id) as t FROM permisos";
    $queryr = mysqli_query($link,$sqlr);
    $rowr = mysqli_fetch_assoc($queryr);
    $nr=$rowr['t'];
    $sqlp="SELECT BIN(permis) AS alt FROM usuaris WHERE uid='".$uid."'";
    $queryp = mysqli_query($link,$sqlp);
    $rowp = mysqli_fetch_assoc($queryp);
    $permis=substr(str_repeat("0", $nr).$rowp['alt'],-$nr);
    $sqlp="SELECT * FROM permisos WHERE codi='".$codi."'";
    $queryp = mysqli_query($link,$sqlp);
    while ($rowp = mysqli_fetch_assoc($queryp)) {
      $p=substr($permis,-$rowp['id'],1);
    }
    return($p);
}?>