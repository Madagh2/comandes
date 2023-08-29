<?php include ("seguridad.php");?>
<!DOCTYPE html>
<html lang="ca">
<head>
<?php include ("head.php");?>
</head>
<body>
<main>
<?php
include("conexion.php");
$titol="Gestió de comandes";
include ("capg.php");
$uid=$_SESSION['uid'];
$torna="menu";
if (isset($_GET['data'])) {$data=$_GET['data'];} else {$data=date('d/m/Y');}
$dm=explode('/',$data);
$todayg=$dm['2']."-".$dm['1']."-".$dm['0'];
$dat=mktime(0,0,0,$dm['1'],$dm['0'],$dm['2']);
$avui=$dat;
?>
<div id="container">
    <div class="row">
        <div class="col s12">
            <div class="card-panel">
                <div class="card-content">
                    <a href="comand.php" class="<?php echo $colortit;?>"><i class="material-icons">shopping_cart</i> Comandes</a>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
<?php include("footer.php");?>
</body>
</html>