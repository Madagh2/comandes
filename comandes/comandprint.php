<?php include ("seguridad.php");?>
<html>
<head>
<?php include ("headp.php");?>
<script>
function val(pagina) {
    window.open(pagina,'Val de compra','height=500,width=1020,resizable=yes,scrollbars=yes,status=no,toolbar=no,menubar=yes,location=no,marginweight=0,screenX=1500,screenY=0,left=1500,top=0');
}
</script>
</head>
<body>
<?php 
include("conexion.php");
$sw = isset($_GET['sw']) ? $_GET['sw'] : "false";
$ad = isset($_GET['ad']) ? $_GET['ad'] : "false";
$dep = isset($_GET['dep']) ? $_GET['dep'] : "t";
?>
<div id="webborder">
    <h1 class="c"><img src="img/logocentre.png" style="height: 3em;"> Comandes</h1>
    <?php $a=$_SESSION['anyacad'];
    $departs = array();
    if (tabla_existe("comanda".$a,$link,$db)=="Taula no existent") {
        echo "<div class='card'>No s'ha creat la taula de comandes. Fes clic ";
        echo ($_SESSION['nivell']=="0" ? "<a href='xmlcomand.php?url=comand'>aquí</a> per crear les taules comanda".$a." i comandadetall".$a."." : "Parla amb l'administrador de l'aplicació.");
        echo "</div>";
        exit();
    }
    if (permis('comand')==1) {
        $file="deps".$_SESSION['anyacad'];
            $sqlcom = (file_exists($file) ? "SELECT * FROM ".$file." ORDER BY departament" : "SELECT DISTINCT(departament) FROM usuaris WHERE departament NOT IN ('Altres', 'No docent') ORDER BY departament");
        $rescom = mysqli_query($link,$sqlcom);
        while($rowcom = mysqli_fetch_array($rescom)) {
            $departs[]=$rowcom['departament'];
        }
        $departs[]="No docent";
        $departs[]="Centre";
    } else {
        $departs[]=$_SESSION['depart'];
    }
    
    foreach ($departs as $depart) {
        if ($depart==$dep OR $dep=="t") {
            $supertotal=0;
            $sql = "select * from comanda".$a." WHERE (departament='".$depart."'";
            $sql.= (permis('centre')==1 AND permis('comand')!=1) ? " OR uid='".$_SESSION['uid']."')" : ")";
            $sql.= ($sw=="false") ? " AND (edaut<>'S' OR (edaut='S' AND valimpr='N'))" : "";
            $sql.=" order by data desc";
            $res = mysqli_query($link,$sql);
            if (mysqli_num_rows($res)!=0 OR $ad!="on") {?>    
                <section>
                    <h4 class="mostra"><?php echo $depart;?></h4>
                    <br>
                    <table id="incid" class="ancho noborde red09">
                        <tr>
                            <th class="anchomin">Data</th>
                            <th class="anchomin">Autoritzat</th>
                            <th>Professor/a</th>
                            <th>Matèria<br>Curs</th>
                            <th>Proveïdor</th>
                            <th>Detall</th>
                            <th class="anchomin">Total</th>            
                        </tr>

                    <?php 
                    while($row = mysqli_fetch_array ($res))
                    {
                        $cl="No";
                        $id = $row['id'];
                        $uid = $row['uid'];
                        $profe = stripslashes($row['profe']);
                        $departament = $row['departament'];
                        $materia = stripslashes($row['materia']);
                        $curs = stripslashes($row['curs']);
                        $proveidor = stripslashes($row['proveidor']);
                        $md=explode(' ',$row['data']);
                        $dmd=explode('-',$md[0]);
                        $data=$dmd[2].'/'.$dmd[1].'/'.$dmd[0];
                        $mdc=explode(' ',$row['cdautdata']);
                        $dmdc=explode('-',$mdc[0]);
                        $datac=$dmdc[2].'/'.$dmdc[1].'/'.$dmdc[0];
                        if ($dmdc[2]!="00") {$cl="CD";}
                        $cdaut = $row['cdaut'];
                        $mde=explode(' ',$row['edautdata']);
                        $dmde=explode('-',$mde[0]);
                        $datae=$dmde[2].'/'.$dmde[1].'/'.$dmde[0];
                        if ($dmde[2]!="00") {$cl="Si";}
                        $edaut = $row['edaut'];
                        $val = $row['val'];
                        $valimpr = $row['valimpr'];
                        $adjunt = $row['adjunt'];
                        $observacions = stripslashes($row['observacions']);
                        ?>
                        <tr class="<?php echo $cl;?>">
                            <td><?php echo $data;?></td>
                            <td><?php $pen="Pendent";
                                if ($dmde[2]!="00") {$pen=$datae;}
                                echo $pen;
                                if ($observacions!="") {echo "<br>",$observacions;}?>
                            </td>
                            <td><?php echo $profe;?></td>
                            <td><?php echo $materia,"<br>",$curs;?></td>
                            <td><?php echo $proveidor;?></td>
                            <?php 
                            $cont="1";
                            $total=0;
                            $lm="";
                            $sqld = "select * from comandadetall".$a." WHERE idcom='".$id."' ORDER BY id";
                            $resd = mysqli_query($link,$sqld);
                            while($rowd = mysqli_fetch_array ($resd))
                            {
                                $program = stripslashes($rowd['program']);
                                $material = stripslashes($rowd['material']);
                                $quantitat = $rowd['quantitat'];
                                $preu = $rowd['preu'];
                                $cont++;
                                $total+=$quantitat*$preu;
                                $supertotal+=$quantitat*$preu;
                                $lm.="- ".$quantitat." ".$material."<br>";
                            }
                            if ($adjunt!="") {
                                $lm='<span class="material-icons">file_present</span>&nbsp;Full de comanda    ';
                            }?>
                            <td><?php echo substr($lm, 0, -4);?></td>
                            <td class="anchomin d"><?php echo number_format($total, 2, ',', ' ');?>&nbsp;&euro;</td>
                        </tr>
                    <?php }?>  
                        <tr>
                            <th colspan="6">TOTAL:</th>
                            <th class="anchomin d"><?php echo number_format($supertotal, 2, ',', ' ');?>&nbsp;&euro;</th>
                        </tr>
                    </table>  
                    <br>
                </section>
        <?php }
        }
    }?>
</div>
<footer class="footer-copyright <?php echo $colornav;?>">
    <div class="c red08 notranslate">
        &copy; 2020 <?php include "dades/centre.php";?> - <?php include "dades/adreca.php";?>, <?php include "dades/cp.php";?> <?php include "dades/localitat.php";?> (Illes Balears)</span>&nbsp;ESPANYA. Telèfon <?php include "dades/tel.php";?>
    </div>
</footer>
</body>
</html>