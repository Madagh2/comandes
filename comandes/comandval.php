<?php include ("seguridad.php");?>
<html>
<head>
    <?php 
    include("headp.php");
    include("conexion.php");
    $cid=$_GET['cid'];
    $a=$_SESSION['anyacad'];
    mysqli_query($link,"UPDATE comanda".$a." SET valimpr='S' WHERE id='".$cid."'");
    $sql = "select * from comanda".$a." WHERE id='".$cid."'";
    $res = mysqli_query($link,$sql);
    while($row = mysqli_fetch_array ($res))
    {
        $uid=$row['uid'];
        $val=$row['val'];
        $profe = $row['profe'];
        $departament = $row['departament'];
        $materia = $row['materia'];
        $curs = $row['curs'];
        $proveidor = $row['proveidor'];
    }?>
    <title>Val de compra <?php echo substr("0000".$val,-4);?></title>
</head>
<body onload="window.print();">
<div id="webborder">
<?php 
$mesos=array("de gener","de febrer","de març","d'abril","de maig","de juny","de juliol","d'agost","de setembre","d'octubre","de novembre","de desembre");

$d = array();
$sqld = "select * from dades";
$resd = mysqli_query($link,$sqld);
while($rowd = mysqli_fetch_array ($resd))
{
    $d[$rowd['camp']]=$rowd['valor'];
}
?>
<section class="oculto i c">Imprimeix aquest val de compra amb el menú del teu navegador</section>
<section style="font-size: 12pt;" id="infofam">
<table class="ancho noborde">
    <tr>
        <td class="anchomin"><img src="img/logocentre.png" height="25mm" alt="<?php echo $d['centre'];?>" /></td>
        <td class="d" style="height: 1em;">Núm. <?php echo substr("0000".$val,-4);?></td>
    </tr>
    <tr>
        <td class="anchomin" style="font-size: 7pt;">
            <?php echo $d['adreca'],"<br>",$d['cp']," ",$d['localitat']," (Illes Balears)<br>Tel. (+34) ",$d['tel'],"<br>Fax. (+34) ",$d['fax'],"<br>CIF: ",$d['cif'],"<br>",$d['email'],"<br>",$d['web'];?>
        </td>
        <td class="c" style="font-size: 14pt; font-weight: bold; padding-left: 3em;">Val de petició de compra de material fungible o inventariable per a pràctiques docents</td>
    </tr>
</table>
<p>Departament <?php echo $departament;?></p>
<p>Petició feta per <?php echo $profe;?></p>

<table id="completa" class="noborde">
    <tr>
        <td style="width: 10%;">Quantitat</td><td style="width: 60%;">Material que es precisa</td><td style="width: 10%;">Preu/Unit</td><td style="width: 10%;">Preu</td>
    </tr>
<?php 
$cont="1";
$total=0;
$sql = "select * from comandadetall".$a." WHERE idcom='".$cid."' ORDER BY id";
$res = mysqli_query($link,$sql);
while($row = mysqli_fetch_array ($res))
{
    $id = $row['id'];
    $material = $row['material'];
    $quantitat = $row['quantitat'];
    $preu = $row['preu'];
    ?>
    <tr>
        <td><?php echo $quantitat;?></td>
        <td><?php echo $material;?></td>
        <td><?php echo number_format($preu, 2, ',', ' ');?>&nbsp;&euro;</td>
        <td><?php echo number_format($quantitat*$preu, 2, ',', ' ');?>&nbsp;&euro;</td>
    </tr><?php 
    $cont++;
    $total+=$quantitat*$preu;
}?>
    <tr>
        <td colspan="3">TOTAL:</td>
        <td><?php echo number_format($total, 2, ',', ' ');?>&nbsp;&euro;</td>
    </tr>
</table>
<table class="ancho noborde">
    <tr class="red09">
        <td class="ancho33 top"><?php  if ($departament!="Centre") {?>El/la cap de departament<br><span class="red09">Signat:</span><div><img src="img/firma<?php  echo preg_replace("/[^A-Za-z0-9]/", '', $departament);?>.png" style="width: 4.2cm"></div><?php  }?></td>
        <td class="ancho33 top">Vist i plau l'administrador/a<br><span class="red09">Signat:</span><div><img src="img/firmasello.png" style="width: 4.2cm"></div></td>
        <td class="ancho33 top"><?php echo $d['localitat'],", ",date('d')," ",$mesos[date('m')-1]," de ",date('Y');?></td>
    </tr>
</table>
</section>
</div>
</body>
</html>