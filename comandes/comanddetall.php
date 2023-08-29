<?php include ("seguridad.php");?>
<!DOCTYPE html>
<html lang="ca">
<head>
<?php include ("head.php");?>
<script type="text/javascript">
    function validar() {
        if(document.actunitat.preu.value > 0){
            alert("No has validat la darrera línia");
            return false;
        } else {
            return true;
        }
    }
</script>
</head>
<body>
<?php 
include("conexion.php");
$cid=$_GET['cid'];
$a=$_SESSION['anyacad'];
$sqld = "select * from comandadetall".$a." WHERE idcom='".$cid."' ORDER BY id";
$resd = mysqli_query($link,$sqld);
$numdet=  mysqli_num_rows($resd);
$sql = "select * from comanda".$a." WHERE id='".$cid."'";
echo "<!-- ",$sqld,"\n",$sql," -->";
$res = mysqli_query($link,$sql);
while($row = mysqli_fetch_array($res))
{
    $uid=$row['uid'];
    $profe = stripslashes($row['profe']);
    $departament = $row['departament'];
    $materia = stripslashes($row['materia']);
    $curs = stripslashes($row['curs']);
    $proveidor = stripslashes($row['proveidor']);
    $adjunt = $row['adjunt'];
}
$titol="Detall comanda";
include ("capg.php");
?>
<main>
<?php 
$envia="Desar canvis";
$st="Actualitza";
include("comandform.php");?>

<div class="container" id="detall">
    <div class="card">
        <h4 class="mostra">Detall</h4>
        <form name="actunitat" action="comanddetallact.php" method="POST" class="oculto">
            <div class="row">
                <div class="col s12">
                    <table class="stripped">
                        <tr>
                            <th>N.</th><th class="ancho33">Unitat programació</th><th>Concepte</th><th>Quant.</th><th>Preu/Un.</th><th>Preu</th><th>Esbor.</th>
                        </tr>
                    <?php 
                    $cont="1";
                    $total=0;
                    $sqld = "select * from comandadetall".$a." WHERE idcom='".$cid."' ORDER BY id";
                    $resd = mysqli_query($link,$sqld);
                    while($rowd = mysqli_fetch_array ($resd))
                    {
                        $id = $rowd['id'];
                        $program = stripslashes($rowd['program']);
                        $material = stripslashes($rowd['material']);
                        $quantitat = $rowd['quantitat'];
                        $preu = $rowd['preu'];
                        ?>
                        <tr>
                            <td><?php echo $cont;?></td>
                            <td>
                                <div class="input-field col s12">
                                    <input type="text" value="<?php echo $program;?>" id="program<?php echo $id;?>" name="program<?php echo $id;?>"/>
                                </div>
                            </td>
                            <td>
                                <div class="input-field">
                                    <input type="text" value="<?php echo $material;?>" id="material<?php echo $id;?>" name="material<?php echo $id;?>"/>
                                </div>
                            </td>
                            <td>
                                <div class="input-field">
                                    <input type="number" value="<?php echo $quantitat;?>" id="quantitat<?php echo $id;?>" name="quantitat<?php echo $id;?>"/>
                                </div>
                            </td>
                            <td>
                                <div class="input-field">
                                    <input type="number" step="0.01" value="<?php echo $preu;?>" id="preu<?php echo $id;?>" name="preu<?php echo $id;?>"/>
                                </div>
                            </td>
                            <td>
                                <div class="input-field">
                                    <input type="text" value="<?php echo $quantitat*$preu,'€';?>"  readonly="readonly"/>
                                </div>
                            </td>
                            <td class="center">
                                <label>
                                    <input type="checkbox" name="esborrar<?php echo $id;?>" value="si" />
                                    <span></span>
                                </label>
                            </td>
                        </tr><?php 
                        $cont++;
                        $total+=$quantitat*$preu;
                    }
                    if ($adjunt!="" && $cont>1) {} else {
                        $ro = ($adjunt!="" ? " readonly" : "");
                        $ma = ($adjunt!="" ? "Full de comanda" : "");
                        $qu = ($adjunt!="" ? "1" : "");?>
                        <tr>
                            <td><?php echo $cont;?></td>
                            <td>
                                <div class="input-field">
                                    <input type="text" value="" id="program" name="program"/>
                                    <label for="program">Unitat programació</label>
                                </div>
                            </td>
                            <td>
                                <div class="input-field">
                                    <input type="text" value=" <?php echo $ma;?>" id="material" name="material" <?php echo $ro;?>/>
                                    <label for="material">Concepte</label>
                                </div>
                            </td>
                            <td>
                                <div class="input-field">
                                    <input type="number" value="<?php echo $qu;?>" id="quantitat" name="quantitat" <?php echo $ro;?>/>
                                    <label for="quantitat">Quantitat</label>
                                </div>
                            </td>
                            <td>
                                <div class="input-field">
                                    <input type="number" step="0.01" value="" id="preu" name="preu" placeholder="&euro;"/>
                                    <label for="preu">Preu/unitat</label>
                                </div>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php }?>
                        <tr>
                            <td colspan="5">TOTAL:</td>
                            <td class="d"><?php echo number_format($total, 2, ',', ' ');?>&nbsp;&euro;</td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col s4 center">
                    <input type="hidden" name="cid" value="<?php echo $cid;?>" />
                    <button class="btn waves-effect waves-light <?php echo $colorbut;?>" type="submit" name="action"><i class="material-icons tooltipped" data-position="top" data-tooltip="Afegeix o modifica una línia i elimina les assenyalades">add_shopping_cart</i></button>
                </div>
                 <div class="col s4 center">
                    <a href="comandesb.php?cid=<?php echo $cid;?>" class="waves-effect waves-light btn <?php echo $colorbut;?>"><i class="material-icons tooltipped" data-position="top" data-tooltip="Elimina tota la comanda">remove_shopping_cart</i></a>
                </div>
                 <div class="col s4 center">
                    <?php $loc = ($_SESSION['depart']==$departament && $_SESSION['capdep']==1) ? "comandautcd.php?id=".$cid."&au=Si" : "comand.php";
                    if ($cont!="1") {?>
                        <a href="<?php echo $loc;?>" onclick="return validar()" class="waves-effect waves-light btn-small <?php echo $colorbut;?>"><i class="material-icons tooltipped" data-position="top" data-tooltip="Finalitza la comanda">done_all</i></a>
                    <?php } else {?>
                        <a class="waves-effect waves-light btn <?php echo $colornav;?>"><i class="material-icons tooltipped" data-position="top" data-tooltip="Escriu al menys un línia per finalitzar la comanda">done_all</i></a>
                    <?php }?>
                </div>
            </div>
        </form>
    </div>
</div>
</main>   
<?php include("footer.php");
include("footerform.php");
if (isset($_GET['adj'])) {?>
    <script language='javascript'>alert ("Has adjuntat un full de comanda. El detall ha de tenir una única entrada on el preu coincideixi amb el total indicat al document adjunt.");</script>
<?php }?>
</body>
</html>