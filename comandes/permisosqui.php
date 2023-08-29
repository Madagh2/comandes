<?php include ("seguridad.php");
if (permis("usuaris")!=1 AND $_SESSION['nivell']!=0) {
    header ("Location: menu.php");
}?>
<!DOCTYPE html>
<html lang="ca">
<head>
<?php include ("head.php");
function dec2bin($dec) {
    // Better function for dec to bin. Support much bigger values, but doesn’t support signs
    for($b='',$r=$dec;$r>1;){
        $n = floor($r/2); $b = ($r-$n*2).$b; $r = $n; // $r%2 is inaccurate when using bigger values (like 11.435.168.214)!
    }
    return ($r%2).$b;
}?>
</head>
<body>
<?php include("conexion.php");
$titol="Gestió de permisos individuals";
include ("capg.php");?>

<main>
<?php
if ($_SESSION['nivell']<'1') {?>
<div class="container">
    <a href="permisosges.php">Llistat d'accions</a><br>
</div>
<?php }?>
<div class="container">
<!-- Permisos -->
    <?php $sqlp="SELECT * FROM permisos order by id";
    $queryp = mysqli_query($link,$sqlp);
    while ($rowp = mysqli_fetch_assoc($queryp)) {?>
        <div class="card">
            <h5 class="header <?php echo $colortit;?>"><?php echo $rowp['descr']," (",$rowp['codi'],")";?></h5>
            <div>
                <?php $sql="SELECT * FROM usuaris WHERE autoritzat='1'";
                $res = mysqli_query($link,$sql) or die("La següent consulta té qualque error:<br>nSQL: <b>".$sqldep."</b>");
                while ($row = mysqli_fetch_array ($res)) {
                    if (permisuid($rowp['codi'], $row['uid'])==1) {?>
                        <a href="usuedit.php?uid=<?php echo $row['uid'];?>" /><?php echo $row['nom'];?></a><br>
                    <?php }
                }?>
            </div>                
        </div>
    <?php }?>
</div>
</main>
<?php include("footer.php");?>
</body>
</html>
