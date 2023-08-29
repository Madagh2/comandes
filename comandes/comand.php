<?php include("seguridad.php");?>
<!DOCTYPE html>
<html lang="ca">
<head>
<?php include("head.php");?>
<script>
function val(pagina) {
    window.open(pagina,'Val de compra','height=500,width=1020,resizable=yes,scrollbars=yes,status=no,toolbar=no,menubar=yes,location=no,marginweight=0,screenX=1500,screenY=0,left=1500,top=0');
}
</script>
</head>
<body>
<?php 
include("conexion.php");
$titol="Gestió de Comandes";
include("capg.php");?>
<main>
<div class="container">
<?php $departs = array();
if (tabla_existe("comanda".$a,$link,$db)=="Taula no existent") {
    echo "<div class='card'>No s'ha creat la taula de comandes. ";
    echo ($_SESSION['nivell']=="0" ? "Fes clic <a href='xmlcomand.php?url=comand'>aquí</a> per crear les taules comanda".$a." i comandadetall".$a."." : "Parla amb l'administrador de l'aplicació.");
    echo "</div>";
    exit();
}
if (permis('comand')==1) {
    $file="deps".$a;
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

$sw = isset($_GET['sw']) ? $_GET['sw'] : "false";
$ad = isset($_GET['ad']) ? $_GET['ad'] : "false";
$dep = isset($_GET['dep']) ? $_GET['dep'] : "t";?>
<div class="card">
  <form action="comand.php" method="GET">
    <div class="row">
        <!-- Comandes pendents -->
        <div class="col s4 tooltipped" data-position="bottom" data-tooltip="Mostra només comandes pendents d'autoritzar">
          <div class="switch">
            <label>
              Tramitades. Pendents
              <input type="checkbox"<?php echo ($sw=='on' ? ' checked="checked"' : '');?> id="sw" name="sw" onclick="this.form.submit();">
              <span class="lever"></span>
              Totes
            </label>
          </div>      
        </div>
        <?php if (permis('comand')==1) {?>
        <!-- Amaga departaments -->
        <div class="col s4 tooltipped" data-position="bottom" data-tooltip="Amaga departaments sense comandes">
          <div class="switch">
            <label>
              Amagar. No
              <input type="checkbox"<?php echo ($ad=='on' ? ' checked="checked"' : '');?> id="ad" name="ad" onclick="this.form.submit();">
              <span class="lever"></span>
              Sí
            </label>
          </div>      
        </div>
        <!-- Departament -->
        <div class="input-field col s4">     
            <?php $options = array();
            $opt = '<option value="t"';
            if ($dep=="t") {$opt.=' selected=""';}
            $opt .='>Tots</option>';
            $options[] = $opt;
              $file="deps".$a;
              $sqld = (file_exists($file) ? "SELECT * FROM ".$file." ORDER BY departament" : "SELECT DISTINCT(departament) FROM usuaris WHERE departament NOT IN ('Altres', 'No docent') ORDER BY departament");
              $queryd = mysqli_query($link,$sqld);
              while ($rowd = mysqli_fetch_assoc($queryd)) {
                $opt = '<option value="'.$rowd['departament'].'"';
                if ($rowd['departament']==$dep) {$opt.=' selected=""';}
                $opt .='>'.$rowd['departament'].'</option>';
                $options[] = $opt;
              }
              $opt = '<option value="No docent"';
              if ($dep=="No docent") {$opt.=' selected=""';}
              $opt .='>No docent</option>';
              $options[] = $opt;
              $opt = '<option value="Centre"';
              if ($dep=="Centre") {$opt.=' selected=""';}
              $opt .='>Centre</option>';
              $options[] = $opt;
              $options = join("\n", $options);?>
              <select id="dep" name="dep" onchange="this.form.submit();">
                <?php echo $options;?></select>
              <label for="dep">Departament</label>
        </div>

        <?php }?>
    </div>
  </form>
</div>
<?php foreach ($departs as $depart) {
    if ($depart==$dep OR $dep=="t") {
        $clr = array ( "No" => "red","Si" => "green","CD" => "yellow");
        $sql = "select * from comanda".$a." WHERE (departament='".$depart."'";
        $sql.= (permis('centre')==1 AND permis('comand')!=1) ? " OR uid='".$_SESSION['uid']."')" : ")";
        $sql.= ($sw=="false") ? " AND (edaut<>'S' OR (edaut='S' AND valimpr='N'))" : "";
        $sql.=" order by data desc";
        $res = mysqli_query($link,$sql);
        if (mysqli_num_rows($res)!=0 OR $ad!="on") {?>    
            <div class="card">
                <h4 class="mostra header <?php echo $colortit;?>"><?php echo $depart;?></h4>
                <?php $param="";
                $param .= "?sw=".(isset($_GET['sw']) ? $_GET['sw'] : "false");
                $param .= "&ad=".(isset($_GET['ad']) ? $_GET['ad'] : "false");
                $param .= "&dep=".(isset($_GET['dep']) ? $_GET['dep'] : "t");?>
                <a href="comandprint.php<?php echo $param;?>" target="_blank"><i class="material-icons">print</i>Llistat per imprimir</a>
                <table class="highlight responsive-table">
                    <tr class="red08">
                        <?php if ($_SESSION['depart']==$depart or permis('comand')==1) {?>
                        <th>Edita</th>
                        <?php }
                        if (permis('comand')==1) {
                            $cols=8;?>
                        <th>Val</th>
                        <?php } else {$cols=7;}?>
                        <th>Data<br><i>Professor/a</i></th>
                        <th>Matèria<br><i>Curs</i></th>
                        <th>Proveïdor</th>
                        <th>Aut CD</th>
                        <?php if (permis('comand')==1) {?>
                        <th>Aut Dir</th>
                        <th>Obs</th>
                        <?php } else {?>
                        <th>Aut Dir</th>
                        <?php }?>
                    </tr>

                <?php 
                $clr = array ( "No" => "red","Si" => "green","CD" => "yellow");
                $sql = "select * from comanda".$a." WHERE (departament='".$depart."'";
                $sql.= (permis('centre')==1 AND permis('comand')!=1) ? " OR uid='".$_SESSION['uid']."')" : ")";
                $sql.= ($sw=="false") ? " AND (edaut<>'S' OR (edaut='S' AND valimpr='N'))" : "";
                $sql.=" order by data desc";
                echo "<!--".$sql."-->";
                $res = mysqli_query($link,$sql);
                while($row = mysqli_fetch_array ($res))
                {
                    $cl="No";
                    $id = $row['id'];
                    $uid = $row['uid'];
                    $profe = stripslashes($row['profe']);
                    $departament = $row['departament'];
                    $materia = stripslashes($row['materia']);
                    $cursc = stripslashes($row['curs']);
                    $sqlc='SELECT * FROM oferta WHERE codi="'.$cursc.'"';
                    $queryc = mysqli_query($link,$sqlc);
                    $rowc = mysqli_fetch_assoc($queryc);
                    $curs=$rowc['nom'];
                        
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
                    <tr class="<?php echo $clr[$cl];?> accent-1">
                        <?php if ($_SESSION['depart']==$depart or permis('comand')==1) {?>
                        <td class="c">
                            <?php if (($_SESSION['capdep']==1 && $edaut!="S") OR ($_SESSION['uid']==$uid && permis('centre')==1 && $departament=="Centre" && $edaut!="S") OR ($_SESSION['uid']==$uid && $cdaut!="S") OR (permis('comand')==1 && $edaut!="S")) {?>
                                <a href="comanddetall.php?cid=<?php echo $id;?>"><i class="material-icons" title="Editar" alt="Editar">edit</i></a>
                            <?php }
                            if ($edaut=="S" && ($_SESSION['capdep']==1 OR $_SESSION['uid']==$uid OR permis('comand')==1)) {
                                $ok="";
                                if ($valimpr=="S") {$ok="ok";}?>
                                <a href="javascript:val('comandval.php?cid=<?php echo $id;?>')"><i class="material-icons" title="Imprimir val de compra" alt="Imprimir val de compra">assignment</i></a>
                            <?php }?>
                        </td>
                        <?php }
                        if (permis('comand')==1) {?>
                        <td><?php echo $val;?></td>
                        <?php }?>
                        <td onclick='javascript:mostrardiv(<?php echo $id;?>);' class="pointer"><?php echo $data,"<br><i>",$profe,"</i>";?></td>
                        <td onclick='javascript:mostrardiv(<?php echo $id;?>);' class="pointer"><?php echo $materia,"<br><i>",$curs,"</i>";?></td>
                        <td><?php echo $proveidor;?></td>
                        <td>
                            <?php $aut="Autoritza";
                            $ch="";
                            $pen="Pendent";
                            if ($dmdc[2]!="00") {
                                $aut="Desautoritza";
                                $ch=' checked="checked"';
                                $pen=$datac;
                            }
                            echo $pen,"<br>";
                            if ($_SESSION['depart']==$departament && $_SESSION['capdep']==1 && $edaut!="S") {?>
                                <div class="switch" onclick="location.href='comandautcd.php?id=<?php echo $id;?>&au=<?php echo $cl;?>'">
                                    <label>
                                        <input type="checkbox" <?php echo $ch;?> title="<?php echo $aut;?>" alt="<?php echo $aut;?>">
                                        <span class="lever"></span>
                                    </label>
                                </div>
                            <?php }?>
                        </td>
                        <td>
                            <?php $aut="Autoritza";
                            $ch="";
                            $pen="Pendent";
                            if ($dmde[2]!="00") {
                                $aut="Desautoritza";
                                $ch=' checked="checked"';
                                $pen=$datae;
                            }
                            echo $pen,"<br>";
                            if (permis('comand')==1 && $cdaut=="S") {?>
                                <div class="switch" onclick="location.href='comandauted.php?id=<?php echo $id;?>&au=<?php echo $cl;?>'">
                                    <label>
                                        <input type="checkbox" <?php echo $ch;?> title="<?php echo $aut;?>" alt="<?php echo $aut;?>">
                                        <span class="lever"></span>
                                    </label>
                                </div>
                            <?php } else {echo $observacions;}?>
                        </td>
                        <?php if (permis('comand')==1) {?>
                            <td>
                                <form method="POST" action="comandauted.php" name="comandnou<?php echo $id;?>" id="comandnou<?php echo $id;?>">
                                    <div class="input-field col s12">
                                        <textarea id="observacions<?php echo $id;?>" name="observacions" class="materialize-textarea" onchange="document.getElementById('comandnou<?php echo $id;?>').submit();"><?php echo $observacions;?></textarea>
                                        <label for="observacions<?php echo $id;?>">Observacions</label>
                                    </div>
                                    <!-- <i class="material-icons right pointer <?php echo $colortit;?>" onclick="document.getElementById('comandnou<?php echo $id;?>').submit();">send</i> -->
                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                </form>
                            </td>
                        <?php }?>
                    </tr>


                    <!-- DETALL COMANDA -->
                    <tr class="<?php echo $cl;?>">
                        <td colspan="<?php echo $cols;?>">
                            <div id="<?php echo $id;?>" style="display: none;" class="detall">
                                <table class="striped" style="background: #fff;">
                                    <tr>
                                        <th>N.</th><th class="ancho33">Programació</th><th>Quantitat</th><th class="ancho33">Concepte</th><th>Preu/Unitat</th><th>Preu</th>
                                    </tr>
                                <?php 
                                $cont="1";
                                $total=0;
                                $sqld = "select * from comandadetall".$a." WHERE idcom='".$id."' ORDER BY id";
                                $resd = mysqli_query($link,$sqld);
                                while($rowd = mysqli_fetch_array ($resd))
                                {
                                    $program = stripslashes($rowd['program']);
                                    $material = stripslashes($rowd['material']);
                                    $quantitat = $rowd['quantitat'];
                                    $preu = $rowd['preu'];
                                    ?>
                                    <tr>
                                        <td><?php echo $cont;?></td>
                                        <td><?php echo $program;?></td>
                                        <td><?php echo $quantitat;?></td>
                                        <td><?php echo $material;?></td>
                                        <td><?php echo number_format($preu, 2, ',', ' ');?>&nbsp;&euro;</td>
                                        <td><?php echo number_format($quantitat*$preu, 2, ',', ' ');?>&nbsp;&euro;</td>
                                    </tr><?php 
                                    $cont++;
                                    $total+=$quantitat*$preu;
                                }?>
                                    <tr>
                                        <td colspan="4">
                                            <?php if ($adjunt!="") {?><a href="adjunts/comandes/<?php echo $adjunt;?>" class="<?php echo $colortit;?>"><i class="material-icons" title="Full de càlcul detall" alt="Full de càlcul detall">file_present</i>&nbsp;Full de comanda</a><?php }?>
                                        </td>
                                        <td><b>TOTAL:</b></td>
                                        <td><b><?php echo number_format($total, 2, ',', ' ');?>&nbsp;&euro;</b></td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                <?php }?>    
                </table>
            </div>
        <?php }
    }
}?>
</div>
<?php 
$uid=$_SESSION['uid'];
$profe = stripslashes($_SESSION['profe']);
$departament = stripslashes($_SESSION['depart']);
$materia = "";
$curs = "";
$proveidor = "";
$cid=0;
$st="Continuar amb la sol·licitud";
include("comandform.php");?>
</main>
<?php include("footer.php");
include("footerform.php");
//include("cf_footereditor.php");?>
</body>
</html>